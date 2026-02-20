<?php

namespace App\Http\Controllers;

use App\Models\MeetingCalendar;
use Illuminate\Http\Request;

class MeetingCalendarController extends Controller
{
    public function index()
    {
        $meetings = MeetingCalendar::orderByDesc('meeting_date')->paginate(12);
        return view('meetings.index', compact('meetings'));
    }

    public function create()
    {
        return view('meetings.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'meeting_date' => 'required|date|unique:meeting_calendars,meeting_date',
            'meeting_title' => 'nullable|string|max:255',
        ]);

        MeetingCalendar::create($validated);

        return redirect()->route('meetings.index')->with('success', 'Meeting date added to calendar.');
    }

    public function edit(MeetingCalendar $meeting)
    {
        return view('meetings.edit', compact('meeting'));
    }

    public function update(Request $request, MeetingCalendar $meeting)
    {
        $validated = $request->validate([
            'meeting_date' => 'required|date|unique:meeting_calendars,meeting_date,' . $meeting->id,
            'meeting_title' => 'nullable|string|max:255',
        ]);

        $meeting->update($validated);

        return redirect()->route('meetings.index')->with('success', 'Meeting calendar updated.');
    }

    public function destroy(MeetingCalendar $meeting)
    {
        $meeting->delete();
        return redirect()->route('meetings.index')->with('success', 'Meeting removed.');
    }
}
