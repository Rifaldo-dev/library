@extends('adminlte::page')

@section('title', 'Penerbit')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h1>Penerbit</h1>
        <a href="{{ route('publishers.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Tambah Penerbit
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
            <form action="{{ route('publishers.index') }}" method="GET" class="form-inline">
                <div class="input-group input-group-sm">
                    <input type="text" name="search" class="form-control" placeholder="Cari penerbit..." value="{{ request('search') }}">
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="submit"><i class="fas fa-search"></i></button>
                        @if(request('search'))
                            <a href="{{ route('publishers.index') }}" class="btn btn-secondary"><i class="fas fa-times"></i></a>
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
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Telepon</th>
                        <th>Jumlah Buku</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($publishers as $publisher)
                        <tr>
                            <td>{{ $loop->iteration + ($publishers->currentPage() - 1) * $publishers->perPage() }}</td>
                            <td>{{ $publisher->name }}</td>
                            <td>{{ $publisher->email ?? '-' }}</td>
                            <td>{{ $publisher->phone ?? '-' }}</td>
                            <td><span class="badge badge-info">{{ $publisher->books_count }}</span></td>
                            <td>
                                <a href="{{ route('publishers.edit', $publisher) }}" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
                                <form action="{{ route('publishers.destroy', $publisher) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus penerbit ini?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="text-center">Belum ada data penerbit.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            {{ $publishers->links() }}
        </div>
    </div>
@stop
