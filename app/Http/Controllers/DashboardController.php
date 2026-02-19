<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Mark;
use App\Models\StudentProductDistribution;
use App\Models\School;
use App\Models\AcademicYear;
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
            'gradeDistribution', 'genderDistribution', 'recentStudents', 'recentDistributions'
        ));
    }
}
