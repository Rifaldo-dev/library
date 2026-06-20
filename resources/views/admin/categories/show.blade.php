@extends('adminlte::page')

@section('title', $category->name)

@section('content_header')
    <h1>Kategori: {{ $category->name }}</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Buku dalam kategori ini</h3>
        </div>
        <div class="card-body table-responsive p-0">
            <table class="table table-hover">
                <thead>
                    <tr><th>Judul</th><th>Penulis</th><th>Stok</th></tr>
                </thead>
                <tbody>
                    @forelse($category->books as $book)
                        <tr>
                            <td>{{ $book->title }}</td>
                            <td>{{ $book->author }}</td>
                            <td>{{ $book->stock }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="3" class="text-center">Tidak ada buku.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            <a href="{{ route('categories.index') }}" class="btn btn-secondary">Kembali</a>
        </div>
    </div>
@stop
