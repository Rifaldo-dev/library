@extends('adminlte::page')

@section('title', 'Peminjaman')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h1>Data Peminjaman</h1>
        <a href="{{ route('loans.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Tambah Peminjaman
        </a>
    </div>
@stop

@section('content')
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
        </div>
    @endif

    <div class="card">
        <div class="card-header">
            <form action="{{ route('loans.index') }}" method="GET" class="form-inline">
                <div class="input-group input-group-sm">
                    <input type="text" name="search" class="form-control" placeholder="Cari buku atau anggota..." value="{{ request('search') }}">
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="submit"><i class="fas fa-search"></i></button>
                        @if(request('search'))
                            <a href="{{ route('loans.index') }}" class="btn btn-secondary"><i class="fas fa-times"></i></a>
                        @endif
                    </div>
                </div>
            </form>
        </div>
        <div class="card-body table-responsive p-0">
            <table class="table table-hover table-striped text-nowrap">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Buku</th>
                        <th>Anggota</th>
                        <th>Tgl Pinjam</th>
                        <th>Tgl Kembali</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($loans as $loan)
                        <tr>
                            <td>{{ $loop->iteration + ($loans->currentPage() - 1) * $loans->perPage() }}</td>
                            <td>{{ $loan->book->title }}</td>
                            <td>{{ $loan->member->name }}</td>
                            <td>{{ $loan->loan_date->format('d/m/Y') }}</td>
                            <td>{{ $loan->return_date ? $loan->return_date->format('d/m/Y') : '-' }}</td>
                            <td>
                                @if($loan->status === 'returned')
                                    <span class="badge badge-success">Dikembalikan</span>
                                @elseif($loan->status === 'overdue')
                                    <span class="badge badge-danger">Terlambat</span>
                                @else
                                    <span class="badge badge-warning">Dipinjam</span>
                                @endif
                            </td>
                            <td>
                                @if($loan->status === 'borrowed' || $loan->status === 'overdue')
                                    <a href="{{ route('loans.edit', $loan) }}" class="btn btn-sm btn-success" title="Kembalikan">
                                        <i class="fas fa-undo"></i>
                                    </a>
                                @endif
                                <form action="{{ route('loans.destroy', $loan) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus data ini?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="text-center">Belum ada data peminjaman.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            {{ $loans->links() }}
        </div>
    </div>
@stop
