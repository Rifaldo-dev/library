<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublisherController;
use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('admin.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('books', BookController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('publishers', PublisherController::class);
    Route::resource('members', MemberController::class);
    Route::resource('loans', LoanController::class);

    Route::get('returns', [LoanController::class, 'returns'])->name('returns.index');
    Route::get('returns/{loan}/edit', [LoanController::class, 'edit'])->name('returns.edit');
    Route::put('returns/{loan}', [LoanController::class, 'update'])->name('returns.update');

    Route::get('reports', [ReportController::class, 'index'])->name('reports.index');

    // Export routes
    Route::get('export/books/pdf', [ExportController::class, 'booksPdf'])->name('export.books.pdf');
    Route::get('export/books/csv', [ExportController::class, 'booksCsv'])->name('export.books.csv');
    Route::get('export/members/pdf', [ExportController::class, 'membersPdf'])->name('export.members.pdf');
    Route::get('export/members/csv', [ExportController::class, 'membersCsv'])->name('export.members.csv');
    Route::get('export/loans/pdf', [ExportController::class, 'loansPdf'])->name('export.loans.pdf');
    Route::get('export/loans/csv', [ExportController::class, 'loansCsv'])->name('export.loans.csv');
});

require __DIR__.'/auth.php';
