<?php

namespace App\Http\Controllers;

use App\Models\PublicExamResult;
use App\Models\PublicExamResultSubject;
use App\Models\Student;
use App\Models\AcademicYear;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PublicExamResultController extends Controller
{
    public function index(Request $request)
    {
        $query = PublicExamResult::with(['student', 'academicYear', 'subjects']);

        if ($request->filled('student_id'))     $query->where('student_id', $request->student_id);
        if ($request->filled('exam_type'))      $query->where('exam_type', $request->exam_type);
        if ($request->filled('exam_year'))      $query->where('exam_year', $request->exam_year);

        $results      = $query->orderByDesc('exam_year')->orderBy('exam_type')->paginate(20)->withQueryString();
        $students     = Student::orderBy('name')->get();
        $examYears    = PublicExamResult::select('exam_year')->distinct()->orderByDesc('exam_year')->pluck('exam_year');

        return view('public-exams.index', compact('results', 'students', 'examYears'));
    }

    public function create()
    {
        $students     = Student::where('current_grade', '>=', 11)->orderBy('name')->get();
        $academicYears = AcademicYear::orderByDesc('year')->get();
        return view('public-exams.create', compact('students', 'academicYears'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'student_id'       => 'required|exists:students,id',
            'academic_year_id' => 'required|exists:academic_years,id',
            'exam_type'        => 'required|in:OL,AL',
            'exam_year'        => 'required|integer|min:2000|max:2099',
            'index_number'     => 'required|string|max:20',
            'result_sheet'     => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'notes'            => 'nullable|string',
            'subjects'         => 'required|array|min:1',
            'subjects.*.name'  => 'required|string|max:100',
            'subjects.*.grade' => 'required|in:A,B,C,S,W,X,AB',
        ]);

        // Handle file upload
        $path = null;
        if ($request->hasFile('result_sheet')) {
            $path = $request->file('result_sheet')->store('public-exams', 'public');
        }

        $result = PublicExamResult::create([
            'student_id'        => $data['student_id'],
            'academic_year_id'  => $data['academic_year_id'],
            'exam_type'         => $data['exam_type'],
            'exam_year'         => $data['exam_year'],
            'index_number'      => $data['index_number'],
            'result_sheet_path' => $path,
            'notes'             => $data['notes'] ?? null,
        ]);

        foreach ($data['subjects'] as $sub) {
            if (!empty($sub['name'])) {
                PublicExamResultSubject::create([
                    'public_exam_result_id' => $result->id,
                    'subject_name'          => $sub['name'],
                    'grade'                 => $sub['grade'],
                ]);
            }
        }

        return redirect()->route('public-exams.show', $result)->with('success', 'Exam result saved successfully.');
    }

    public function show(PublicExamResult $publicExam)
    {
        $publicExam->load(['student', 'academicYear', 'subjects']);
        return view('public-exams.show', compact('publicExam'));
    }

    public function edit(PublicExamResult $publicExam)
    {
        $publicExam->load('subjects');
        $students     = Student::where('current_grade', '>=', 11)->orderBy('name')->get();
        $academicYears = AcademicYear::orderByDesc('year')->get();
        return view('public-exams.edit', compact('publicExam', 'students', 'academicYears'));
    }

    public function update(Request $request, PublicExamResult $publicExam)
    {
        $data = $request->validate([
            'exam_year'        => 'required|integer|min:2000|max:2099',
            'index_number'     => 'required|string|max:20',
            'result_sheet'     => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'notes'            => 'nullable|string',
            'subjects'         => 'required|array|min:1',
            'subjects.*.name'  => 'required|string|max:100',
            'subjects.*.grade' => 'required|in:A,B,C,S,W,X,AB',
        ]);

        // Handle new file upload
        if ($request->hasFile('result_sheet')) {
            if ($publicExam->result_sheet_path) {
                Storage::disk('public')->delete($publicExam->result_sheet_path);
            }
            $data['result_sheet_path'] = $request->file('result_sheet')->store('public-exams', 'public');
        }

        $publicExam->update([
            'exam_year'         => $data['exam_year'],
            'index_number'      => $data['index_number'],
            'result_sheet_path' => $data['result_sheet_path'] ?? $publicExam->result_sheet_path,
            'notes'             => $data['notes'] ?? null,
        ]);

        // Replace all subjects
        $publicExam->subjects()->delete();
        foreach ($data['subjects'] as $sub) {
            if (!empty($sub['name'])) {
                PublicExamResultSubject::create([
                    'public_exam_result_id' => $publicExam->id,
                    'subject_name'          => $sub['name'],
                    'grade'                 => $sub['grade'],
                ]);
            }
        }

        return redirect()->route('public-exams.show', $publicExam)->with('success', 'Result updated.');
    }

    public function destroy(PublicExamResult $publicExam)
    {
        if ($publicExam->result_sheet_path) {
            Storage::disk('public')->delete($publicExam->result_sheet_path);
        }
        $publicExam->delete();
        return redirect()->route('public-exams.index')->with('success', 'Result deleted.');
    }

    // Remove uploaded sheet only
    public function removeSheet(PublicExamResult $publicExam)
    {
        if ($publicExam->result_sheet_path) {
            Storage::disk('public')->delete($publicExam->result_sheet_path);
            $publicExam->update(['result_sheet_path' => null]);
        }
        return back()->with('success', 'Result sheet removed.');
    }
}
