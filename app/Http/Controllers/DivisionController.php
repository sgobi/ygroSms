<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GnDivision;
use App\Models\GsDivision;

class DivisionController extends Controller
{
    public function index()
    {
        $gnDivisions = GnDivision::orderBy('name')->get();
        $gsDivisions = GsDivision::orderBy('name')->get();
        return view('divisions.index', compact('gnDivisions', 'gsDivisions'));
    }

    public function storeGn(Request $request)
    {
        $request->validate(['name' => 'required|string|unique:gn_divisions,name']);
        GnDivision::create(['name' => $request->name]);
        return back()->with('success', 'GN Division added.');
    }

    public function storeGs(Request $request)
    {
        $request->validate(['name' => 'required|string|unique:gs_divisions,name']);
        GsDivision::create(['name' => $request->name]);
        return back()->with('success', 'GS Division added.');
    }

    public function destroyGn(GnDivision $gnDivision)
    {
        $gnDivision->delete();
        return back()->with('success', 'GN Division deleted.');
    }

    public function destroyGs(GsDivision $gsDivision)
    {
        $gsDivision->delete();
        return back()->with('success', 'GS Division deleted.');
    }
}
