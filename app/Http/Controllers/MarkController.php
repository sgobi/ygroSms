<?php

namespace App\Http\Controllers;

use App\Models\Mark;
use App\Models\Student;
use App\Models\Subject;
use App\Models\AcademicYear;
use Illuminate\Http\Request;

class MarkController extends Controller
{
    public function index(Request $request)
    {
        $query = Mark::with(['student', 'subject', 'academicYear']);

        if ($request->filled('student_id')) $query->where('student_id', $request->student_id);
        if ($request->filled('academic_year_id')) $query->where('academic_year_id', $request->academic_year_id);
        if ($request->filled('term')) $query->where('term', $request->term);
        if ($request->filled('grade')) $query->where('grade', $request->grade);

        $marks = $query->orderBy('created_at', 'desc')->paginate(30)->withQueryString();
        $students = Student::orderBy('name')->get();
        $academicYears = AcademicYear::orderByDesc('year')->get();

        return view('marks.index', compact('marks', 'students', 'academicYears'));
    }

    public function create(Request $request)
    {
        $students = Student::orderBy('name')->get();
        $academicYears = AcademicYear::orderByDesc('year')->get();
        $subjects = collect();
        $selectedStudent = null;

        if ($request->filled('student_id')) {
            $selectedStudent = Student::findOrFail($request->student_id);
            $subjects = Subject::where('grade_from', '<=', $selectedStudent->current_grade)
                ->where('grade_to', '>=', $selectedStudent->current_grade)
                ->when($selectedStudent->stream_id, fn($q) => $q->where(fn($q2) =>
                    $q2->where('stream_id', $selectedStudent->stream_id)->orWhereNull('stream_id')
                ))
                ->orderBy('name')->get();
        }

        return view('marks.create', compact('students', 'academicYears', 'subjects', 'selectedStudent'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'student_id' => 'required|exists:students,id',
            'academic_year_id' => 'required|exists:academic_years,id',
            'term' => 'required|in:1,2,3',
            'grade' => 'required|integer|min:1|max:13',
            'marks' => 'required|array',
            'marks.*.subject_id' => 'required|exists:subjects,id',
            'marks.*.marks' => 'nullable|numeric|min:0|max:100',
            'marks.*.remarks' => 'nullable|string',
        ]);

        foreach ($data['marks'] as $entry) {
            if ($entry['marks'] === null) continue;
            Mark::updateOrCreate(
                [
                    'student_id' => $data['student_id'],
                    'subject_id' => $entry['subject_id'],
                    'academic_year_id' => $data['academic_year_id'],
                    'term' => $data['term'],
                ],
                [
                    'grade' => $data['grade'],
                    'marks' => $entry['marks'],
                    'grade_letter' => Mark::computeGradeLetter($entry['marks']),
                    'remarks' => $entry['remarks'] ?? null,
                ]
            );
        }

        return redirect()->route('marks.index', ['student_id' => $data['student_id']])->with('success', 'Marks saved.');
    }

    public function destroy(Mark $mark)
    {
        $mark->delete();
        return back()->with('success', 'Mark deleted.');
    }
}
