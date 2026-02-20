<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Mark;
use App\Models\StudentProductDistribution;
use App\Models\School;
use App\Models\AcademicYear;
use App\Models\DisciplinaryRecord;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalStudents = Student::count();
        $totalSchools = School::count();
        $activeYear = AcademicYear::where('is_active', true)->first();
        $totalDistributions = StudentProductDistribution::count();
        $totalExpense = StudentProductDistribution::selectRaw('SUM(quantity * unit_price) as total')->value('total') ?? 0;

        $disciplineSummary = DisciplinaryRecord::when($activeYear, function ($q) use ($activeYear) {
                return $q->where('academic_year_id', $activeYear->id);
            })
            ->selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();

        $gradeDistribution = Student::selectRaw('current_grade, COUNT(*) as count')
            ->groupBy('current_grade')
            ->orderBy('current_grade')
            ->get();

        $genderDistribution = Student::selectRaw('gender, COUNT(*) as count')
            ->groupBy('gender')
            ->pluck('count', 'gender')
            ->toArray();

        $recentStudents = Student::with('stream')->latest()->take(5)->get();
        $recentDistributions = StudentProductDistribution::with(['student', 'product'])->latest()->take(5)->get();

        return view('dashboard.index', compact(
            'totalStudents', 'totalSchools', 'activeYear',
            'totalDistributions', 'totalExpense',
            'disciplineSummary',
            'gradeDistribution', 'genderDistribution', 'recentStudents', 'recentDistributions'
        ));
    }
}
