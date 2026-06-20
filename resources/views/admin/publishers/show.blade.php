@extends('adminlte::page')

@section('title', $publisher->name)

@section('content_header')
    <h1>Penerbit: {{ $publisher->name }}</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <table class="table table-bordered">
                <tr><th width="150">Nama</th><td>{{ $publisher->name }}</td></tr>
                <tr><th>Alamat</th><td>{{ $publisher->address ?? '-' }}</td></tr>
                <tr><th>Telepon</th><td>{{ $publisher->phone ?? '-' }}</td></tr>
                <tr><th>Email</th><td>{{ $publisher->email ?? '-' }}</td></tr>
            </table>
        </div>
        <div class="card-footer">
            <a href="{{ route('publishers.index') }}" class="btn btn-secondary">Kembali</a>
        </div>
    </div>
@stop
