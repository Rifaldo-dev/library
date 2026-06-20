@extends('adminlte::page')

@section('title', 'Detail Peminjaman')

@section('content_header')
    <h1>Detail Peminjaman</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <table class="table table-bordered">
                <tr><th width="200">Buku</th><td>{{ $loan->book->title }}</td></tr>
                <tr><th>Anggota</th><td>{{ $loan->member->name }}</td></tr>
                <tr><th>Tgl Pinjam</th><td>{{ $loan->loan_date->format('d/m/Y') }}</td></tr>
                <tr><th>Batas Kembali</th><td>{{ $loan->due_date->format('d/m/Y') }}</td></tr>
                <tr><th>Tgl Dikembalikan</th><td>{{ $loan->return_date ? $loan->return_date->format('d/m/Y') : '-' }}</td></tr>
                <tr><th>Status</th><td>
                    @if($loan->status === 'returned')
                        <span class="badge badge-success">Dikembalikan</span>
                    @elseif($loan->status === 'overdue')
                        <span class="badge badge-danger">Terlambat</span>
                    @else
                        <span class="badge badge-warning">Dipinjam</span>
                    @endif
                </td></tr>
            </table>
        </div>
        <div class="card-footer">
            <a href="{{ route('loans.index') }}" class="btn btn-secondary">Kembali</a>
        </div>
    </div>
@stop
