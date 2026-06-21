<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use App\Models\Loan;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        // Filter parameters
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $status = $request->input('status');
        $categoryId = $request->input('category_id');

        // Base query untuk loan dengan filter
        $loanQuery = Loan::query();

        if ($startDate) {
            $loanQuery->where('loan_date', '>=', $startDate);
        }
        if ($endDate) {
            $loanQuery->where('loan_date', '<=', $endDate);
        }
        if ($status) {
            $loanQuery->where('status', $status);
        }
        if ($categoryId) {
            $loanQuery->whereHas('book', fn($q) => $q->where('category_id', $categoryId));
        }

        // Statistik umum (filtered)
        $totalBooks = Book::count();
        $totalMembers = Member::count();
        $totalLoans = (clone $loanQuery)->count();
        $activeLoans = (clone $loanQuery)->whereIn('status', ['borrowed', 'overdue'])->count();
        $overdueLoans = (clone $loanQuery)->where('status', 'overdue')->count();
        $returnedLoans = (clone $loanQuery)->where('status', 'returned')->count();

        // Buku paling banyak dipinjam (filtered)
        $popularBooks = Book::withCount(['loans' => function ($q) use ($startDate, $endDate, $status) {
                if ($startDate) $q->where('loan_date', '>=', $startDate);
                if ($endDate) $q->where('loan_date', '<=', $endDate);
                if ($status) $q->where('status', $status);
            }])
            ->orderByDesc('loans_count')
            ->limit(10)
            ->get();

        // Anggota paling aktif (filtered)
        $activeMembers = Member::withCount(['loans' => function ($q) use ($startDate, $endDate, $status) {
                if ($startDate) $q->where('loan_date', '>=', $startDate);
                if ($endDate) $q->where('loan_date', '<=', $endDate);
                if ($status) $q->where('status', $status);
            }])
            ->orderByDesc('loans_count')
            ->limit(10)
            ->get();

        // Peminjaman per kategori
        $loansByCategory = Category::withCount(['books as loans_count' => function ($query) use ($startDate, $endDate, $status) {
            $query->select(DB::raw('count(*)'))
                ->join('loans', 'loans.book_id', '=', 'books.id');
            if ($startDate) $query->where('loans.loan_date', '>=', $startDate);
            if ($endDate) $query->where('loans.loan_date', '<=', $endDate);
            if ($status) $query->where('loans.status', $status);
        }])->get();

        // Peminjaman per bulan (6 bulan terakhir atau sesuai filter)
        $monthlyQuery = Loan::select(
                DB::raw("TO_CHAR(loan_date, 'YYYY-MM') as month"),
                DB::raw('count(*) as total')
            );

        if ($startDate) {
            $monthlyQuery->where('loan_date', '>=', $startDate);
        } else {
            $monthlyQuery->where('loan_date', '>=', now()->subMonths(6)->startOfMonth());
        }
        if ($endDate) {
            $monthlyQuery->where('loan_date', '<=', $endDate);
        }
        if ($status) {
            $monthlyQuery->where('status', $status);
        }
        if ($categoryId) {
            $monthlyQuery->whereHas('book', fn($q) => $q->where('category_id', $categoryId));
        }

        $monthlyLoans = $monthlyQuery->groupBy('month')->orderBy('month')->get();

        // Data untuk filter dropdown
        $categories = Category::orderBy('name')->get();

        return view('admin.reports.index', compact(
            'totalBooks', 'totalMembers', 'totalLoans',
            'activeLoans', 'overdueLoans', 'returnedLoans',
            'popularBooks', 'activeMembers', 'loansByCategory', 'monthlyLoans',
            'categories', 'startDate', 'endDate', 'status', 'categoryId'
        ));
    }
}
