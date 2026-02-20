<?php

namespace App\Http\Controllers;

use App\Models\DisciplinaryRecord;
use App\Models\Student;
use App\Models\AcademicYear;
use App\Models\MeetingCalendar;
use App\Http\Requests\DisciplinaryRecordRequest;
use Illuminate\Http\Request;

class DisciplinaryRecordController extends Controller
{
    /**
     * Display a listing of disciplinary records with filters.
     */
    public function index(Request $request)
    {
        $query = DisciplinaryRecord::with(['student', 'academicYear', 'meetingCalendar']);

        if ($request->filled('grade')) {
            $query->whereHas('student', function ($q) use ($request) {
                $q->where('current_grade', $request->grade);
            });
        }

        if ($request->filled('month')) {
            $query->where('month', $request->month);
        }

        if ($request->filled('year')) {
            $query->whereHas('academicYear', function ($q) use ($request) {
                $q->where('year', $request->year);
            });
        }

        $records = $query->latest()->paginate(20)->withQueryString();
        $academicYears = AcademicYear::orderByDesc('year')->get();

        return view('discipline.index', compact('records', 'academicYears'));
    }

    /**
     * Show the form for creating a new record.
     */
    public function create(Request $request)
    {
        $students = Student::orderBy('name')->get();
        $academicYears = AcademicYear::orderByDesc('year')->get();
        $activeYearId = AcademicYear::where('is_active', true)->value('id');
        $selectedStudentId = $request->student_id;
        
        // Pass meeting calendar info to UI
        $meetingCalendar = MeetingCalendar::all()->mapWithKeys(function ($item) {
            return [$item->year . '-' . $item->month => true];
        });

        return view('discipline.create', compact('students', 'academicYears', 'activeYearId', 'selectedStudentId', 'meetingCalendar'));
    }

    /**
     * Store a newly created or update an existing resource.
     */
    public function store(DisciplinaryRecordRequest $request)
    {
        $academicYear = AcademicYear::find($request->academic_year_id);
        
        // Find matching meeting month
        $meeting = MeetingCalendar::where('year', $academicYear->year)
            ->where('month', $request->month)
            ->first();

        $record = DisciplinaryRecord::updateOrCreate(
            [
                'student_id' => $request->student_id,
                'academic_year_id' => $request->academic_year_id,
                'month' => $request->month,
            ],
            [
                'meeting_calendar_id' => $meeting?->id,
                // Validated as boolean in the request
                'meeting_participated' => $request->meeting_participated,
                'bill_submitted' => $request->bill_submitted,
            ]
        );

        return redirect()->route('discipline.index')
            ->with('success', 'Tracking record saved successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(DisciplinaryRecord $discipline)
    {
        return view('discipline.show', compact('discipline'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DisciplinaryRecord $discipline)
    {
        $students = Student::orderBy('name')->get();
        $academicYears = AcademicYear::orderByDesc('year')->get();
        
        $meetingCalendar = MeetingCalendar::all()->mapWithKeys(function ($item) {
            return [$item->year . '-' . $item->month => true];
        });

        return view('discipline.edit', compact('discipline', 'students', 'academicYears', 'meetingCalendar'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(DisciplinaryRecordRequest $request, DisciplinaryRecord $discipline)
    {
        $academicYear = AcademicYear::find($request->academic_year_id);
        
        $meeting = MeetingCalendar::where('year', $academicYear->year)
            ->where('month', $request->month)
            ->first();

        $discipline->update(array_merge($request->validated(), [
            'meeting_calendar_id' => $meeting?->id
        ]));

        return redirect()->route('discipline.index')
            ->with('success', 'Tracking record updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DisciplinaryRecord $discipline)
    {
        $discipline->delete();
        return redirect()->route('discipline.index')->with('success', 'Record deleted.');
    }
}
