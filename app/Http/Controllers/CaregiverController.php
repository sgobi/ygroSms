<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Caregiver;

class CaregiverController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $caregivers = Caregiver::latest()->paginate(10);
        return view('caregivers.index', compact('caregivers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('caregivers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'nullable|string|max:10',
            'name' => 'required|string|max:255',
            'address' => 'nullable|string',
            'mobile' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'occupation' => 'nullable|string|max:255',
            'relationship_to_student' => 'nullable|string|max:255',
        ]);

        Caregiver::create($validated);

        return redirect()->route('caregivers.index')->with('success', 'Caregiver added successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $caregiver = Caregiver::findOrFail($id);
        return view('caregivers.edit', compact('caregiver'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'title' => 'nullable|string|max:10',
            'name' => 'required|string|max:255',
            'address' => 'nullable|string',
            'mobile' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'occupation' => 'nullable|string|max:255',
            'relationship_to_student' => 'nullable|string|max:255',
        ]);

        $caregiver = Caregiver::findOrFail($id);
        $caregiver->update($validated);

        return redirect()->route('caregivers.index')->with('success', 'Caregiver updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $caregiver = Caregiver::findOrFail($id);
        $caregiver->delete();

        return redirect()->route('caregivers.index')->with('success', 'Caregiver deleted successfully!');
    }
}
