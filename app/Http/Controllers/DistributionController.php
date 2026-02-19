<?php

namespace App\Http\Controllers;

use App\Models\StudentProductDistribution;
use App\Models\Student;
use App\Models\Product;
use App\Models\AcademicYear;
use Illuminate\Http\Request;

class DistributionController extends Controller
{
    public function index(Request $request)
    {
        $query = StudentProductDistribution::with(['student', 'product', 'academicYear']);

        if ($request->filled('student_id')) $query->where('student_id', $request->student_id);
        if ($request->filled('academic_year_id')) $query->where('academic_year_id', $request->academic_year_id);
        if ($request->filled('product_id')) $query->where('product_id', $request->product_id);

        $distributions = $query->orderBy('date_given', 'desc')->paginate(20)->withQueryString();
        $students = Student::orderBy('name')->get();
        $products = Product::orderBy('name')->get();
        $academicYears = AcademicYear::orderByDesc('year')->get();

        return view('distributions.index', compact('distributions', 'students', 'products', 'academicYears'));
    }

    public function create()
    {
        $students = Student::orderBy('name')->get();
        $products = Product::orderBy('name')->get();
        $academicYears = AcademicYear::orderByDesc('year')->get();
        return view('distributions.create', compact('students', 'products', 'academicYears'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'student_id' => 'required|exists:students,id',
            'product_id' => 'required|exists:products,id',
            'academic_year_id' => 'required|exists:academic_years,id',
            'quantity' => 'required|integer|min:1',
            'date_given' => 'required|date',
            'notes' => 'nullable|string',
        ]);

        $product = Product::findOrFail($data['product_id']);
        $data['unit_price'] = $product->price;

        StudentProductDistribution::create($data);
        return redirect()->route('distributions.index')->with('success', 'Distribution recorded.');
    }

    public function destroy(StudentProductDistribution $distribution)
    {
        $distribution->delete();
        return back()->with('success', 'Record deleted.');
    }
}
