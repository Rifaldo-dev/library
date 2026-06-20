@extends('adminlte::page')

@section('title', $book->title)

@section('content_header')
    <h1>Detail Buku</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-3 text-center">
                    @if($book->cover_url)
                        <img src="{{ $book->cover_url }}" alt="Cover {{ $book->title }}" class="img-fluid rounded" style="max-height: 300px;">
                    @else
                        <div class="bg-secondary text-white d-flex align-items-center justify-content-center rounded" style="height: 250px;">
                            <i class="fas fa-book fa-4x"></i>
                        </div>
                    @endif
                </div>
                <div class="col-md-9">
                    <table class="table table-bordered">
                        <tr><th width="200">Judul</th><td>{{ $book->title }}</td></tr>
                        <tr><th>ISBN</th><td>{{ $book->isbn ?? '-' }}</td></tr>
                        <tr><th>Penulis</th><td>{{ $book->author }}</td></tr>
                        <tr><th>Kategori</th><td>{{ $book->category->name }}</td></tr>
                        <tr><th>Penerbit</th><td>{{ $book->publisher->name }}</td></tr>
                        <tr><th>Tahun Terbit</th><td>{{ $book->year_published ?? '-' }}</td></tr>
                        <tr><th>Stok</th><td>{{ $book->stock }}</td></tr>
                        <tr><th>Deskripsi</th><td>{{ $book->description ?? '-' }}</td></tr>
                    </table>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <a href="{{ route('books.index') }}" class="btn btn-secondary">Kembali</a>
            <a href="{{ route('books.edit', $book) }}" class="btn btn-warning">Edit</a>
        </div>
    </div>
@stop
