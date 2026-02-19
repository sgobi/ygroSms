<?php

namespace App\Http\Controllers;

use App\Models\AcademicYear;
use Illuminate\Http\Request;

class AcademicYearController extends Controller
{
    public function index()
    {
        $years = AcademicYear::orderByDesc('year')->paginate(20);
        return view('academic-years.index', compact('years'));
    }

    public function create()
    {
        return view('academic-years.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'year' => 'required|integer|min:2010|max:2100|unique:academic_years,year',
            'is_active' => 'boolean',
        ]);

        if (!empty($data['is_active'])) {
            AcademicYear::where('is_active', true)->update(['is_active' => false]);
        }
        AcademicYear::create($data);

        return redirect()->route('academic-years.index')->with('success', 'Academic year added.');
    }

    public function edit(AcademicYear $academicYear)
    {
        return view('academic-years.edit', compact('academicYear'));
    }

    public function update(Request $request, AcademicYear $academicYear)
    {
        $data = $request->validate([
            'year' => 'required|integer|min:2010|max:2100|unique:academic_years,year,' . $academicYear->id,
            'is_active' => 'boolean',
        ]);

        if (!empty($data['is_active'])) {
            AcademicYear::where('is_active', true)->update(['is_active' => false]);
        }
        $academicYear->update($data);

        return redirect()->route('academic-years.index')->with('success', 'Academic year updated.');
    }

    public function destroy(AcademicYear $academicYear)
    {
        $academicYear->delete();
        return redirect()->route('academic-years.index')->with('success', 'Academic year deleted.');
    }

    public function setActive(AcademicYear $academicYear)
    {
        AcademicYear::where('is_active', true)->update(['is_active' => false]);
        $academicYear->update(['is_active' => true]);
        return redirect()->route('academic-years.index')->with('success', "Year {$academicYear->year} set as active.");
    }
}
