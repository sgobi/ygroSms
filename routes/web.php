<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SchoolController;
use App\Http\Controllers\AcademicYearController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\MarkController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\DistributionController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\PublicExamController;
use App\Http\Controllers\DivisionController;
use App\Http\Controllers\DonorController;
use App\Http\Controllers\CaregiverController;
use App\Http\Controllers\MeetingCalendarController;

// Redirect root to dashboard or login
Route::get('/', function () {
    return auth()->check() ? redirect()->route('dashboard') : redirect()->route('login');
});

// Authentication Routes
Route::get('/login', [\App\Http\Controllers\Auth\LoginController::class, 'showLoginForm'])->name('login')->middleware('guest');
Route::post('/login', [\App\Http\Controllers\Auth\LoginController::class, 'login'])->middleware('guest');
Route::post('/logout', [\App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');

// Protected Routes
Route::middleware(['auth'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Students
    Route::resource('students', StudentController::class);
    Route::post('/students/{student}/school-history', [StudentController::class, 'addSchoolHistory'])->name('students.addSchoolHistory');

    // Schools
    Route::resource('schools', SchoolController::class)->except(['show']);

    // Academic Years
    Route::resource('academic-years', AcademicYearController::class)->except(['show']);
    Route::post('/academic-years/{academicYear}/set-active', [AcademicYearController::class, 'setActive'])->name('academic-years.setActive');

    // Subjects
    Route::resource('subjects', SubjectController::class)->except(['show']);

    // Marks
    Route::get('/marks', [MarkController::class, 'index'])->name('marks.index');
    Route::get('/marks/create', [MarkController::class, 'create'])->name('marks.create');
    Route::post('/marks', [MarkController::class, 'store'])->name('marks.store');
    Route::delete('/marks/{mark}', [MarkController::class, 'destroy'])->name('marks.destroy');

    // Products
    Route::resource('products', ProductController::class)->except(['show']);

    // Distributions (Welfare)
    Route::get('/distributions', [DistributionController::class, 'index'])->name('distributions.index');
    Route::get('/distributions/create', [DistributionController::class, 'create'])->name('distributions.create');
    Route::post('/distributions', [DistributionController::class, 'store'])->name('distributions.store');
    Route::delete('/distributions/{distribution}', [DistributionController::class, 'destroy'])->name('distributions.destroy');

    // Reports
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/term', [ReportController::class, 'term'])->name('reports.term');
    Route::get('/reports/year', [ReportController::class, 'year'])->name('reports.year');
    Route::get('/reports/history', [ReportController::class, 'history'])->name('reports.history');
    Route::get('/reports/distribution', [ReportController::class, 'distribution'])->name('reports.distribution');
    Route::get('/reports/expense', [ReportController::class, 'expense'])->name('reports.expense');
    Route::get('/reports/product-summary', [ReportController::class, 'productSummary'])->name('reports.productSummary');

    // Public Exams
    Route::resource('public-exams', PublicExamController::class);
    Route::get('public-exams/{publicExam}/results/create', [PublicExamController::class, 'createResult'])->name('public-exams.results.create');
    Route::post('public-exams/{publicExam}/results', [PublicExamController::class, 'storeResult'])->name('public-exams.results.store');
    Route::get('public-exams/results/{entry}/download', [PublicExamController::class, 'downloadResultSheet'])->name('public-exams.results.download');
    Route::delete('public-exams/results/{entry}', [PublicExamController::class, 'destroyResult'])->name('public-exams.results.destroy');
    Route::get('public-exams/{publicExam}/report', [PublicExamController::class, 'report'])->name('public-exams.report');

    // Divisions
    Route::get('/divisions', [DivisionController::class, 'index'])->name('divisions.index');
    Route::post('/divisions/gn', [DivisionController::class, 'storeGn'])->name('divisions.storeGn');
    Route::post('/divisions/gs', [DivisionController::class, 'storeGs'])->name('divisions.storeGs');
    Route::delete('/divisions/gn/{gnDivision}', [DivisionController::class, 'destroyGn'])->name('divisions.destroyGn');
    Route::delete('/divisions/gs/{gsDivision}', [DivisionController::class, 'destroyGs'])->name('divisions.destroyGs');

    // Donors
    Route::resource('donors', DonorController::class);

    // Caregivers
    Route::resource('caregivers', CaregiverController::class);

    // Meeting Calendar
    Route::resource('meetings', MeetingCalendarController::class);

    // Disciplinary History
    Route::resource('discipline', \App\Http\Controllers\DisciplinaryRecordController::class);
});
