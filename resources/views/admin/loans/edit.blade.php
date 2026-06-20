@extends('adminlte::page')

@section('title', 'Pengembalian Buku')

@section('content_header')
    <h1>Pengembalian Buku</h1>
@stop

@section('content')
    <div class="card">
        <form action="{{ route('loans.update', $loan) }}" method="POST">
            @csrf @method('PUT')
            <div class="card-body">
                <table class="table table-bordered">
                    <tr><th width="200">Buku</th><td>{{ $loan->book->title }}</td></tr>
                    <tr><th>Anggota</th><td>{{ $loan->member->name }}</td></tr>
                    <tr><th>Tgl Pinjam</th><td>{{ $loan->loan_date->format('d/m/Y') }}</td></tr>
                    <tr><th>Batas Kembali</th><td>{{ $loan->due_date->format('d/m/Y') }}</td></tr>
                </table>
                <div class="form-group mt-3">
                    <label for="return_date">Tanggal Pengembalian</label>
                    <input type="date" name="return_date" id="return_date" class="form-control @error('return_date') is-invalid @enderror" value="{{ old('return_date', date('Y-m-d')) }}" required>
                    @error('return_date')<span class="invalid-feedback">{{ $message }}</span>@enderror
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-success">Konfirmasi Pengembalian</button>
                <a href="{{ route('loans.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
@stop
