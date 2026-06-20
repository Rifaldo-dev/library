@extends('adminlte::page')

@section('title', $member->name)

@section('content_header')
    <h1>Anggota: {{ $member->name }}</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header"><h3 class="card-title">Info Anggota</h3></div>
                <div class="card-body">
                    <p><strong>Kode:</strong> {{ $member->member_code }}</p>
                    <p><strong>Email:</strong> {{ $member->email }}</p>
                    <p><strong>Telepon:</strong> {{ $member->phone ?? '-' }}</p>
                    <p><strong>Alamat:</strong> {{ $member->address ?? '-' }}</p>
                    <p><strong>Bergabung:</strong> {{ $member->joined_at->format('d/m/Y') }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"><h3 class="card-title">Riwayat Peminjaman</h3></div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover">
                        <thead>
                            <tr><th>Buku</th><th>Tgl Pinjam</th><th>Status</th></tr>
                        </thead>
                        <tbody>
                            @forelse($member->loans as $loan)
                                <tr>
                                    <td>{{ $loan->book->title }}</td>
                                    <td>{{ $loan->loan_date->format('d/m/Y') }}</td>
                                    <td>
                                        @if($loan->status === 'returned')
                                            <span class="badge badge-success">Dikembalikan</span>
                                        @elseif($loan->status === 'overdue')
                                            <span class="badge badge-danger">Terlambat</span>
                                        @else
                                            <span class="badge badge-warning">Dipinjam</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="3" class="text-center">Belum ada peminjaman.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <a href="{{ route('members.index') }}" class="btn btn-secondary">Kembali</a>
@stop
