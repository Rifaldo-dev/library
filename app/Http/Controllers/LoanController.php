<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Loan;
use App\Models\Member;
use Illuminate\Http\Request;

class LoanController extends Controller
{
    public function index(Request $request)
    {
        $query = Loan::with(['book', 'member']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->whereHas('book', fn($b) => $b->where('title', 'like', "%{$search}%"))
                  ->orWhereHas('member', fn($m) => $m->where('name', 'like', "%{$search}%"));
            });
        }

        $loans = $query->latest()->paginate(15)->withQueryString();
        return view('admin.loans.index', compact('loans'));
    }

    public function returns(Request $request)
    {
        $query = Loan::with(['book', 'member'])->whereIn('status', ['borrowed', 'overdue']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->whereHas('book', fn($b) => $b->where('title', 'like', "%{$search}%"))
                  ->orWhereHas('member', fn($m) => $m->where('name', 'like', "%{$search}%"));
            });
        }

        $loans = $query->latest()->paginate(15)->withQueryString();
        return view('admin.returns.index', compact('loans'));
    }

    public function create()
    {
        $books = Book::where('stock', '>', 0)->get();
        $members = Member::all();
        return view('admin.loans.create', compact('books', 'members'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'book_id' => 'required|exists:books,id',
            'member_id' => 'required|exists:members,id',
            'loan_date' => 'required|date',
            'due_date' => 'required|date|after:loan_date',
        ]);
        $validated['status'] = 'borrowed';

        Loan::create($validated);

        // Kurangi stok buku
        Book::find($validated['book_id'])->decrement('stock');

        return redirect()->route('loans.index')->with('success', 'Peminjaman berhasil dicatat.');
    }

    public function show(Loan $loan)
    {
        $loan->load(['book', 'member']);
        return view('admin.loans.show', compact('loan'));
    }

    public function edit(Loan $loan)
    {
        $books = Book::all();
        $members = Member::all();
        return view('admin.loans.edit', compact('loan', 'books', 'members'));
    }

    public function update(Request $request, Loan $loan)
    {
        $validated = $request->validate([
            'return_date' => 'required|date|after_or_equal:loan_date',
        ]);
        $validated['status'] = 'returned';

        $loan->update($validated);

        // Tambah stok buku kembali
        $loan->book->increment('stock');

        return redirect()->route('loans.index')->with('success', 'Pengembalian berhasil dicatat.');
    }

    public function destroy(Loan $loan)
    {
        if ($loan->status === 'borrowed') {
            $loan->book->increment('stock');
        }
        $loan->delete();
        return redirect()->route('loans.index')->with('success', 'Data peminjaman berhasil dihapus.');
    }
}
