<?php

namespace App\Http\Controllers;

use App\Models\Donor;
use Illuminate\Http\Request;

class DonorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $donors = Donor::orderBy('name')->paginate(20);
        return view('donors.index', compact('donors'));
    }

    public function create()
    {
        return view('donors.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'nullable|string',
            'name' => 'required|string|max:255',
            'address' => 'nullable|string',
            'phone' => 'nullable|string',
            'email' => 'nullable|email',
        ]);

        Donor::create($data);

        return redirect()->route('donors.index')->with('success', 'Donor added successfully.');
    }

    public function show(Donor $donor)
    {
        return view('donors.show', compact('donor'));
    }

    public function edit(Donor $donor)
    {
        return view('donors.edit', compact('donor'));
    }

    public function update(Request $request, Donor $donor)
    {
        $data = $request->validate([
            'title' => 'nullable|string',
            'name' => 'required|string|max:255',
            'address' => 'nullable|string',
            'phone' => 'nullable|string',
            'email' => 'nullable|email',
        ]);

        $donor->update($data);

        return redirect()->route('donors.index')->with('success', 'Donor updated successfully.');
    }

    public function destroy(Donor $donor)
    {
        $donor->delete();
        return redirect()->route('donors.index')->with('success', 'Donor deleted.');
    }
}
