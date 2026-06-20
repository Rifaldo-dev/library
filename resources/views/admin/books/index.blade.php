@extends('adminlte::page')

@section('title', 'Daftar Buku')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h1>Daftar Buku</h1>
        <div>
            <a href="{{ route('export.books.pdf') }}" class="btn btn-danger"><i class="fas fa-file-pdf"></i> PDF</a>
            <a href="{{ route('export.books.csv') }}" class="btn btn-success"><i class="fas fa-file-csv"></i> CSV</a>
            <a href="{{ route('books.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Tambah Buku</a>
        </div>
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
            <form action="{{ route('books.index') }}" method="GET" class="form-inline">
                <div class="input-group input-group-sm">
                    <input type="text" name="search" class="form-control" placeholder="Cari judul, penulis, ISBN..." value="{{ request('search') }}">
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="submit"><i class="fas fa-search"></i></button>
                        @if(request('search'))
                            <a href="{{ route('books.index') }}" class="btn btn-secondary"><i class="fas fa-times"></i></a>
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
                        <th>Judul</th>
                        <th>Penulis</th>
                        <th>Kategori</th>
                        <th>Penerbit</th>
                        <th>Stok</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($books as $book)
                        <tr>
                            <td>{{ $loop->iteration + ($books->currentPage() - 1) * $books->perPage() }}</td>
                            <td>{{ $book->title }}</td>
                            <td>{{ $book->author }}</td>
                            <td>{{ $book->category->name }}</td>
                            <td>{{ $book->publisher->name }}</td>
                            <td><span class="badge badge-{{ $book->stock > 0 ? 'success' : 'danger' }}">{{ $book->stock }}</span></td>
                            <td>
                                <a href="{{ route('books.show', $book) }}" class="btn btn-sm btn-info"><i class="fas fa-eye"></i></a>
                                <a href="{{ route('books.edit', $book) }}" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
                                <form action="{{ route('books.destroy', $book) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus buku ini?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="text-center">Belum ada data buku.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            {{ $books->links() }}
        </div>
    </div>
@stop
