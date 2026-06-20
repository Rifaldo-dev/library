<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Loan;
use App\Models\Member;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class ExportController extends Controller
{
    // Export Daftar Buku
    public function booksPdf()
    {
        $books = Book::with(['category', 'publisher'])->get();
        $pdf = Pdf::loadView('admin.exports.books-pdf', compact('books'))
            ->setPaper('a4', 'landscape');
        return $pdf->download('daftar-buku.pdf');
    }

    public function booksCsv()
    {
        $books = Book::with(['category', 'publisher'])->get();

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="daftar-buku.csv"',
        ];

        $callback = function () use ($books) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['No', 'Judul', 'Penulis', 'Kategori', 'Penerbit', 'Tahun', 'Stok', 'ISBN']);

            foreach ($books as $i => $book) {
                fputcsv($file, [
                    $i + 1,
                    $book->title,
                    $book->author,
                    $book->category->name,
                    $book->publisher->name,
                    $book->year_published,
                    $book->stock,
                    $book->isbn,
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    // Export Daftar Anggota
    public function membersPdf()
    {
        $members = Member::withCount('loans')->get();
        $pdf = Pdf::loadView('admin.exports.members-pdf', compact('members'))
            ->setPaper('a4', 'landscape');
        return $pdf->download('daftar-anggota.pdf');
    }

    public function membersCsv()
    {
        $members = Member::withCount('loans')->get();

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="daftar-anggota.csv"',
        ];

        $callback = function () use ($members) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['No', 'Kode', 'Nama', 'Email', 'Telepon', 'Bergabung', 'Total Peminjaman']);

            foreach ($members as $i => $member) {
                fputcsv($file, [
                    $i + 1,
                    $member->member_code,
                    $member->name,
                    $member->email,
                    $member->phone,
                    $member->joined_at->format('d/m/Y'),
                    $member->loans_count,
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    // Export Laporan Peminjaman
    public function loansPdf(Request $request)
    {
        $query = Loan::with(['book', 'member']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $loans = $query->latest('loan_date')->get();
        $pdf = Pdf::loadView('admin.exports.loans-pdf', compact('loans'))
            ->setPaper('a4', 'landscape');
        return $pdf->download('laporan-peminjaman.pdf');
    }

    public function loansCsv(Request $request)
    {
        $query = Loan::with(['book', 'member']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $loans = $query->latest('loan_date')->get();

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="laporan-peminjaman.csv"',
        ];

        $callback = function () use ($loans) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['No', 'Buku', 'Anggota', 'Tgl Pinjam', 'Batas Kembali', 'Tgl Kembali', 'Status']);

            foreach ($loans as $i => $loan) {
                fputcsv($file, [
                    $i + 1,
                    $loan->book->title,
                    $loan->member->name,
                    $loan->loan_date->format('d/m/Y'),
                    $loan->due_date->format('d/m/Y'),
                    $loan->return_date ? $loan->return_date->format('d/m/Y') : '-',
                    $loan->status,
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
