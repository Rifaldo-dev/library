@extends('adminlte::page')

@section('title', 'Tambah Peminjaman')

@section('content_header')
    <h1>Tambah Peminjaman</h1>
@stop

@section('content')
    <div class="card">
        <form action="{{ route('loans.store') }}" method="POST">
            @csrf
            <div class="card-body">
                <div class="form-group">
                    <label for="book_id">Buku</label>
                    <select name="book_id" id="book_id" class="form-control @error('book_id') is-invalid @enderror" required>
                        <option value="">-- Pilih Buku --</option>
                        @foreach($books as $book)
                            <option value="{{ $book->id }}" {{ old('book_id') == $book->id ? 'selected' : '' }}>{{ $book->title }} (Stok: {{ $book->stock }})</option>
                        @endforeach
                    </select>
                    @error('book_id')<span class="invalid-feedback">{{ $message }}</span>@enderror
                </div>
                <div class="form-group">
                    <label for="member_id">Anggota</label>
                    <select name="member_id" id="member_id" class="form-control @error('member_id') is-invalid @enderror" required>
                        <option value="">-- Pilih Anggota --</option>
                        @foreach($members as $member)
                            <option value="{{ $member->id }}" {{ old('member_id') == $member->id ? 'selected' : '' }}>{{ $member->name }} ({{ $member->member_code }})</option>
                        @endforeach
                    </select>
                    @error('member_id')<span class="invalid-feedback">{{ $message }}</span>@enderror
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="loan_date">Tanggal Pinjam</label>
                            <input type="date" name="loan_date" id="loan_date" class="form-control @error('loan_date') is-invalid @enderror" value="{{ old('loan_date', date('Y-m-d')) }}" required>
                            @error('loan_date')<span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="due_date">Tanggal Kembali</label>
                            <input type="date" name="due_date" id="due_date" class="form-control @error('due_date') is-invalid @enderror" value="{{ old('due_date', date('Y-m-d', strtotime('+14 days'))) }}" required>
                            @error('due_date')<span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('loans.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
@stop
