@extends('adminlte::page')

@section('title', 'Edit Buku')

@section('content_header')
    <h1>Edit Buku</h1>
@stop

@section('content')
    <div class="card">
        <form action="{{ route('books.update', $book) }}" method="POST" enctype="multipart/form-data">
            @csrf @method('PUT')
            <div class="card-body">
                <div class="form-group">
                    <label for="title">Judul</label>
                    <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $book->title) }}" required>
                    @error('title')<span class="invalid-feedback">{{ $message }}</span>@enderror
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="isbn">ISBN</label>
                            <input type="text" name="isbn" id="isbn" class="form-control @error('isbn') is-invalid @enderror" value="{{ old('isbn', $book->isbn) }}">
                            @error('isbn')<span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="author">Penulis</label>
                            <input type="text" name="author" id="author" class="form-control @error('author') is-invalid @enderror" value="{{ old('author', $book->author) }}" required>
                            @error('author')<span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="category_id">Kategori</label>
                            <select name="category_id" id="category_id" class="form-control" required>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}" {{ old('category_id', $book->category_id) == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="publisher_id">Penerbit</label>
                            <select name="publisher_id" id="publisher_id" class="form-control" required>
                                @foreach($publishers as $pub)
                                    <option value="{{ $pub->id }}" {{ old('publisher_id', $book->publisher_id) == $pub->id ? 'selected' : '' }}>{{ $pub->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="year_published">Tahun</label>
                            <input type="number" name="year_published" id="year_published" class="form-control" value="{{ old('year_published', $book->year_published) }}" min="1900" max="{{ date('Y') }}">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="stock">Stok</label>
                            <input type="number" name="stock" id="stock" class="form-control" value="{{ old('stock', $book->stock) }}" min="0" required>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="description">Deskripsi</label>
                    <textarea name="description" id="description" class="form-control" rows="3">{{ old('description', $book->description) }}</textarea>
                </div>
                <div class="form-group">
                    <label for="cover">Cover Buku</label>
                    @if($book->cover_url)
                        <div class="mb-2">
                            <img src="{{ $book->cover_url }}" alt="Cover" style="max-height: 150px; border-radius: 4px;">
                        </div>
                    @endif
                    <div class="input-group">
                        <div class="custom-file">
                            <input type="file" name="cover" id="cover" class="custom-file-input @error('cover') is-invalid @enderror" accept="image/*">
                            <label class="custom-file-label" for="cover">{{ $book->cover_url ? 'Ganti cover...' : 'Pilih gambar...' }}</label>
                        </div>
                    </div>
                    @error('cover')<span class="text-danger text-sm">{{ $message }}</span>@enderror
                    <small class="text-muted">Format: JPEG, PNG, WEBP. Maks: 2MB</small>
                    <div id="cover-preview" class="mt-2" style="display:none;">
                        <img id="cover-preview-img" src="" alt="Preview" class="img-fluid rounded" style="max-height: 200px;">
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Update</button>
                <a href="{{ route('books.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
@stop

@section('js')
    <script>
        document.getElementById('cover').addEventListener('change', function(e) {
            var file = e.target.files[0];
            if (file) {
                e.target.nextElementSibling.textContent = file.name;
                var reader = new FileReader();
                reader.onload = function(ev) {
                    document.getElementById('cover-preview-img').src = ev.target.result;
                    document.getElementById('cover-preview').style.display = 'block';
                };
                reader.readAsDataURL(file);
            }
        });
    </script>
@stop
