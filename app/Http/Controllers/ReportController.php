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
    public function index()
    {
        // Statistik umum
        $totalBooks = Book::count();
        $totalMembers = Member::count();
        $totalLoans = Loan::count();
        $activeLoans = Loan::whereIn('status', ['borrowed', 'overdue'])->count();
        $overdueLoans = Loan::where('status', 'overdue')->count();
        $returnedLoans = Loan::where('status', 'returned')->count();

        // Buku paling banyak dipinjam
        $popularBooks = Book::withCount('loans')
            ->orderByDesc('loans_count')
            ->limit(10)
            ->get();

        // Anggota paling aktif
        $activeMembers = Member::withCount('loans')
            ->orderByDesc('loans_count')
            ->limit(10)
            ->get();

        // Peminjaman per kategori
        $loansByCategory = Category::withCount(['books as loans_count' => function ($query) {
            $query->select(DB::raw('count(*)'))
                ->join('loans', 'loans.book_id', '=', 'books.id');
        }])->get();

        // Peminjaman per bulan (6 bulan terakhir)
        $monthlyLoans = Loan::select(
                DB::raw("strftime('%Y-%m', loan_date) as month"),
                DB::raw('count(*) as total')
            )
            ->where('loan_date', '>=', now()->subMonths(6)->startOfMonth())
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        return view('admin.reports.index', compact(
            'totalBooks', 'totalMembers', 'totalLoans',
            'activeLoans', 'overdueLoans', 'returnedLoans',
            'popularBooks', 'activeMembers', 'loansByCategory', 'monthlyLoans'
        ));
    }
}
