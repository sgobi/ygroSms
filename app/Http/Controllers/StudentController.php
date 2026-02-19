<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Stream;
use App\Models\School;
use App\Models\StudentSchoolHistory;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $query = Student::with(['stream', 'currentSchool.school']);

        if ($request->filled('grade')) {
            $query->where('current_grade', $request->grade);
        }
        if ($request->filled('stream_id')) {
            $query->where('stream_id', $request->stream_id);
        }
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $students = $query->orderBy('name')->paginate(20)->withQueryString();
        $streams = Stream::all();

        return view('students.index', compact('students', 'streams'));
    }

    public function create()
    {
        $streams = Stream::all();
        $schools = School::orderBy('name')->get();
        $donors = \App\Models\Donor::orderBy('name')->get();
        $caregivers = \App\Models\Caregiver::orderBy('name')->get();
        $gnDivisions = Student::getGnDivisions();
        $gsDivisions = Student::getGsDivisions();
        return view('students.create', compact('streams', 'schools', 'donors', 'caregivers', 'gnDivisions', 'gsDivisions'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'admission_number' => 'nullable|string|max:50|unique:students,admission_number',
            'dob' => 'nullable|date',
            'gender' => 'nullable|in:Male,Female,Other',
            'address' => 'nullable|string',
            'parent_name' => 'nullable|string|max:255',
            'contact' => 'nullable|string|max:20',
            'medical_emergency_name' => 'nullable|string|max:255',
            'medical_emergency_contact' => 'nullable|string|max:255',
            'gn_division' => 'nullable|string|max:255',
            'gs_division' => 'nullable|string|max:255',
            'admission_year' => 'required|integer|min:2010|max:2100',
            'ol_index' => 'nullable|string|max:50',
            'al_index' => 'nullable|string|max:50',
            'current_grade' => 'required|integer|min:1|max:13',
            'stream_id' => 'nullable|exists:streams,id',
            'school_id' => 'nullable|exists:schools,id',
            'from_year' => 'nullable|integer|min:2010|max:2100',
            'donor_id' => 'nullable|exists:donors,id',
            'caregiver_id' => 'nullable|exists:caregivers,id',
        ]);

        $student = Student::create($data);

        // Add initial school history
        if ($request->school_id && $request->from_year) {
            StudentSchoolHistory::create([
                'student_id' => $student->id,
                'school_id' => $request->school_id,
                'from_year' => $request->from_year,
            ]);
        }

        return redirect()->route('students.show', $student)->with('success', 'Student added successfully.');
    }

    public function show(Student $student)
    {
        $student->load(['stream', 'currentSchool.school', 'donor', 'caregiver', 'marks.academicYear', 'marks.subject', 'publicExamEntries.publicExam', 'publicExamEntries.results.subject', 'distributions.academicYear', 'distributions.product']);
        return view('students.show', compact('student'));
    }

    public function edit(Student $student)
    {
        $streams = Stream::all();
        $schools = School::orderBy('name')->get();
        $donors = \App\Models\Donor::orderBy('name')->get();
        $caregivers = \App\Models\Caregiver::orderBy('name')->get();
        $gnDivisions = Student::getGnDivisions();
        $gsDivisions = Student::getGsDivisions();
        return view('students.edit', compact('student', 'streams', 'schools', 'donors', 'caregivers', 'gnDivisions', 'gsDivisions'));
    }

    public function update(Request $request, Student $student)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'admission_number' => 'nullable|string|max:50|unique:students,admission_number,' . $student->id,
            'dob' => 'nullable|date',
            'gender' => 'nullable|in:Male,Female,Other',
            'address' => 'nullable|string',
            'parent_name' => 'nullable|string|max:255',
            'contact' => 'nullable|string|max:20',
            'medical_emergency_name' => 'nullable|string|max:255',
            'medical_emergency_contact' => 'nullable|string|max:255',
            'gn_division' => 'nullable|string|max:255',
            'gs_division' => 'nullable|string|max:255',
            'admission_year' => 'required|integer|min:2010|max:2100',
            'ol_index' => 'nullable|string|max:50',
            'al_index' => 'nullable|string|max:50',
            'current_grade' => 'required|integer|min:1|max:13',
            'stream_id' => 'nullable|exists:streams,id',
            'donor_id' => 'nullable|exists:donors,id',
            'caregiver_id' => 'nullable|exists:caregivers,id',
        ]);

        $student->update($data);

        return redirect()->route('students.show', $student)->with('success', 'Student updated successfully.');
    }

    public function destroy(Student $student)
    {
        $student->delete();
        return redirect()->route('students.index')->with('success', 'Student deleted.');
    }

    public function addSchoolHistory(Request $request, Student $student)
    {
        $data = $request->validate([
            'school_id' => 'required|exists:schools,id',
            'from_year' => 'required|integer',
            'to_year' => 'nullable|integer',
        ]);

        // Close previous current school
        StudentSchoolHistory::where('student_id', $student->id)->whereNull('to_year')
            ->update(['to_year' => $data['from_year'] - 1]);

        StudentSchoolHistory::create(['student_id' => $student->id] + $data);

        return redirect()->route('students.show', $student)->with('success', 'School history updated.');
    }
}
