<?php

namespace App\Http\Controllers;

use App\Models\Mark;
use App\Models\Student;
use App\Models\AcademicYear;
use App\Models\StudentProductDistribution;
use App\Models\Product;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        $academicYears = AcademicYear::orderByDesc('year')->get();
        $students = Student::orderBy('name')->get();
        return view('reports.index', compact('academicYears', 'students'));
    }

    // Term Report
    public function term(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'academic_year_id' => 'required|exists:academic_years,id',
            'term' => 'required|in:1,2,3',
        ]);

        $student = Student::with('stream')->findOrFail($request->student_id);
        $academicYear = AcademicYear::findOrFail($request->academic_year_id);
        $marks = Mark::with('subject')
            ->where('student_id', $student->id)
            ->where('academic_year_id', $academicYear->id)
            ->where('term', $request->term)
            ->get();

        if ($request->has('pdf')) {
            $pdf = Pdf::loadView('pdf.term_report', compact('student', 'academicYear', 'marks', 'request'));
            return $pdf->download("term_{$request->term}_report_{$student->name}.pdf");
        }

        return view('reports.term', compact('student', 'academicYear', 'marks', 'request'));
    }

    // Year Report
    public function year(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'academic_year_id' => 'required|exists:academic_years,id',
        ]);

        $student = Student::with('stream')->findOrFail($request->student_id);
        $academicYear = AcademicYear::findOrFail($request->academic_year_id);
        $marks = Mark::with('subject')
            ->where('student_id', $student->id)
            ->where('academic_year_id', $academicYear->id)
            ->orderBy('term')->orderBy('subject_id')
            ->get()
            ->groupBy('term');

        if ($request->has('pdf')) {
            $pdf = Pdf::loadView('pdf.year_report', compact('student', 'academicYear', 'marks'));
            return $pdf->download("year_report_{$academicYear->year}_{$student->name}.pdf");
        }

        return view('reports.year', compact('student', 'academicYear', 'marks'));
    }

    // Full Academic History
    public function history(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
        ]);

        $student = Student::with(['stream', 'schoolHistories.school'])->findOrFail($request->student_id);
        $marks = Mark::with(['subject', 'academicYear'])
            ->where('student_id', $student->id)
            ->orderBy('academic_year_id')->orderBy('term')
            ->get()
            ->groupBy('academicYear.year');

        if ($request->has('pdf')) {
            $pdf = Pdf::loadView('pdf.academic_history', compact('student', 'marks'));
            return $pdf->download("academic_history_{$student->name}.pdf");
        }

        return view('reports.history', compact('student', 'marks'));
    }

    // Distribution Report (student-wise)
    public function distribution(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
        ]);

        $student = Student::findOrFail($request->student_id);
        $distributions = StudentProductDistribution::with(['product', 'academicYear'])
            ->where('student_id', $student->id)
            ->orderBy('date_given', 'desc')->get();
        $total = $distributions->sum(fn($d) => $d->quantity * $d->unit_price);

        if ($request->has('pdf')) {
            $pdf = Pdf::loadView('pdf.distribution_report', compact('student', 'distributions', 'total'));
            return $pdf->download("distribution_{$student->name}.pdf");
        }

        return view('reports.distribution', compact('student', 'distributions', 'total'));
    }

    // Year-wise expense report
    public function expense(Request $request)
    {
        $years = StudentProductDistribution::with('academicYear')
            ->selectRaw('academic_year_id, SUM(quantity * unit_price) as total_expense, SUM(quantity) as total_quantity')
            ->groupBy('academic_year_id')
            ->orderBy('academic_year_id')
            ->get();

        if ($request->has('pdf')) {
            $pdf = Pdf::loadView('pdf.expense_report', compact('years'));
            return $pdf->download('expense_report.pdf');
        }

        return view('reports.expense', compact('years'));
    }

    // Product summary
    public function productSummary(Request $request)
    {
        $products = Product::withTrashed()
            ->withSum('distributions as total_value', \DB::raw('quantity * unit_price'))
            ->withSum('distributions as total_quantity', 'quantity')
            ->get();

        if ($request->has('pdf')) {
            $pdf = Pdf::loadView('pdf.product_summary', compact('products'));
            return $pdf->download('product_summary.pdf');
        }

        return view('reports.product_summary', compact('products'));
    }
}
