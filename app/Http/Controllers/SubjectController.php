<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use App\Models\Stream;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    public function index(Request $request)
    {
        $query = Subject::with('stream');
        if ($request->filled('grade')) {
            $query->where('grade_from', '<=', $request->grade)->where('grade_to', '>=', $request->grade);
        }
        $subjects = $query->orderBy('grade_from')->orderBy('name')->paginate(20)->withQueryString();
        return view('subjects.index', compact('subjects'));
    }

    public function create()
    {
        $streams = Stream::all();
        return view('subjects.create', compact('streams'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'grade_from' => 'required|integer|min:1|max:13',
            'grade_to' => 'required|integer|min:1|max:13|gte:grade_from',
            'stream_id' => 'nullable|exists:streams,id',
            'is_optional' => 'boolean',
        ]);

        Subject::create($data);
        return redirect()->route('subjects.index')->with('success', 'Subject added.');
    }

    public function edit(Subject $subject)
    {
        $streams = Stream::all();
        return view('subjects.edit', compact('subject', 'streams'));
    }

    public function update(Request $request, Subject $subject)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'grade_from' => 'required|integer|min:1|max:13',
            'grade_to' => 'required|integer|min:1|max:13|gte:grade_from',
            'stream_id' => 'nullable|exists:streams,id',
            'is_optional' => 'boolean',
        ]);

        $subject->update($data);
        return redirect()->route('subjects.index')->with('success', 'Subject updated.');
    }

    public function destroy(Subject $subject)
    {
        $subject->delete();
        return redirect()->route('subjects.index')->with('success', 'Subject deleted.');
    }
}
