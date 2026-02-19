<?php

namespace App\Http\Controllers;

use App\Models\PublicExam;
use App\Models\Student;
use App\Models\Subject;
use App\Models\StudentPublicExam;
use App\Models\PublicExamResult;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

class PublicExamController extends Controller
{
    public function index()
    {
        $exams = PublicExam::orderBy('exam_date', 'desc')->get();
        return view('public-exams.index', compact('exams'));
    }

    public function report(PublicExam $publicExam)
    {
        $publicExam->load(['studentPublicExams.student', 'studentPublicExams.results.subject']);
        $pdf = Pdf::loadView('pdf.public_exam_report', compact('publicExam'));
        return $pdf->download("PublicExamReport_{$publicExam->name}.pdf");
    }

    public function create()
    {
        return view('public-exams.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'exam_date' => 'nullable|date',
            'description' => 'nullable|string',
        ]);

        PublicExam::create($data);
        return redirect()->route('public-exams.index')->with('success', 'Public Exam created.');
    }

    public function show(PublicExam $publicExam)
    {
        $publicExam->load(['studentPublicExams.student', 'studentPublicExams.results.subject']);
        return view('public-exams.show', compact('publicExam'));
    }

    public function edit(PublicExam $publicExam)
    {
        return view('public-exams.edit', compact('publicExam'));
    }

    public function update(Request $request, PublicExam $publicExam)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'exam_date' => 'nullable|date',
            'description' => 'nullable|string',
        ]);

        $publicExam->update($data);
        return redirect()->route('public-exams.index')->with('success', 'Public Exam updated.');
    }

    public function destroy(PublicExam $publicExam)
    {
        $publicExam->delete();
        return redirect()->route('public-exams.index')->with('success', 'Public Exam deleted.');
    }

    // --- Student Result Management ---

    public function createResult(PublicExam $publicExam)
    {
        $students = Student::orderBy('name')->get(); 
        $subjects = Subject::orderBy('name')->get();
        return view('public-exams.entry', compact('publicExam', 'students', 'subjects'));
    }

    public function storeResult(Request $request, PublicExam $publicExam)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'index_number' => 'required|string|max:50',
            'result_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120', // 5MB max
            'results' => 'required|array',
            'results.*.subject_id' => 'required|exists:subjects,id',
            'results.*.grade' => 'required|string|max:5',
        ]);

        // Check if student already has entry for this exam
        $entry = StudentPublicExam::firstOrCreate(
            [
                'student_id' => $request->student_id,
                'public_exam_id' => $publicExam->id,
            ],
            [
                'index_number' => $request->index_number,
            ]
        );

        // Update index number if it changed (or was just created)
        $entry->index_number = $request->index_number;

        // Handle File Upload
        if ($request->hasFile('result_file')) {
            // Delete old file if exists
            if ($entry->result_file_path && Storage::disk('public')->exists($entry->result_file_path)) {
                Storage::disk('public')->delete($entry->result_file_path);
            }
            $path = $request->file('result_file')->store('public_exam_results', 'public');
            $entry->result_file_path = $path;
        }
        $entry->save();

        // Save Results
        // Clear old results to avoid duplicates or handle merge? 
        // Let's delete old ones and recreate for simplicity as this is an "entry" form
        $entry->results()->delete();

        foreach ($request->results as $res) {
            if (!empty($res['grade'])) {
                PublicExamResult::create([
                    'student_public_exam_id' => $entry->id,
                    'subject_id' => $res['subject_id'],
                    'grade' => $res['grade'],
                ]);
            }
        }

        return redirect()->route('public-exams.show', $publicExam)->with('success', 'Results added for student.');
    }

    public function downloadResultSheet(StudentPublicExam $entry)
    {
        if (!$entry->result_file_path || !Storage::disk('public')->exists($entry->result_file_path)) {
            return back()->with('error', 'File not found.');
        }
        return Storage::disk('public')->download($entry->result_file_path, "ResultSheet_{$entry->index_number}.pdf");
    }

    public function destroyResult(StudentPublicExam $entry)
    {
        if ($entry->result_file_path && Storage::disk('public')->exists($entry->result_file_path)) {
            Storage::disk('public')->delete($entry->result_file_path);
        }
        $examId = $entry->public_exam_id;
        $entry->delete();
        return redirect()->route('public-exams.show', $examId)->with('success', 'Student entry deleted.');
    }
}
