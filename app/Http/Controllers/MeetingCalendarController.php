<?php

namespace App\Http\Controllers;

use App\Models\MeetingCalendar;
use Illuminate\Http\Request;

class MeetingCalendarController extends Controller
{
    public function index()
    {
        $meetings = MeetingCalendar::orderByDesc('year')->orderByDesc('month')->paginate(12);
        return view('meetings.index', compact('meetings'));
    }

    public function create()
    {
        return view('meetings.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'year' => 'required|integer|min:2020|max:2099',
            'month' => 'required|integer|min:1|max:12',
            'meeting_title' => 'nullable|string|max:255',
            'meeting_date' => 'nullable|date',
        ]);

        MeetingCalendar::create($validated);

        return redirect()->route('meetings.index')->with('success', 'Meeting month added to calendar.');
    }

    public function edit(MeetingCalendar $meeting)
    {
        return view('meetings.edit', compact('meeting'));
    }

    public function update(Request $request, MeetingCalendar $meeting)
    {
        $validated = $request->validate([
            'year' => 'required|integer|min:2020|max:2099',
            'month' => 'required|integer|min:1|max:12',
            'meeting_title' => 'nullable|string|max:255',
            'meeting_date' => 'nullable|date',
        ]);

        $meeting->update($validated);

        return redirect()->route('meetings.index')->with('success', 'Meeting calendar updated.');
    }

    public function destroy(MeetingCalendar $meeting)
    {
        $meeting->delete();
        return redirect()->route('meetings.index')->with('success', 'Meeting month removed.');
    }
}
