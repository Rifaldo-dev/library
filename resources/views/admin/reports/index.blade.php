@extends('adminlte::page')

@section('title', 'Laporan & Statistik')

@section('content_header')
    <div class="d-flex justify-content-between">
        <h1>Laporan & Statistik</h1>
        <div>
            <div class="btn-group mr-2">
                <button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown">
                    <i class="fas fa-file-pdf"></i> Export PDF
                </button>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="{{ route('export.books.pdf') }}"><i class="fas fa-book mr-2"></i>Daftar Buku</a>
                    <a class="dropdown-item" href="{{ route('export.members.pdf') }}"><i class="fas fa-users mr-2"></i>Daftar Anggota</a>
                    <a class="dropdown-item" href="{{ route('export.loans.pdf', request()->only(['start_date', 'end_date', 'status', 'category_id'])) }}"><i class="fas fa-exchange-alt mr-2"></i>Laporan Peminjaman</a>
                </div>
            </div>
            <div class="btn-group">
                <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown">
                    <i class="fas fa-file-excel"></i> Export CSV
                </button>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="{{ route('export.books.csv') }}"><i class="fas fa-book mr-2"></i>Daftar Buku</a>
                    <a class="dropdown-item" href="{{ route('export.members.csv') }}"><i class="fas fa-users mr-2"></i>Daftar Anggota</a>
                    <a class="dropdown-item" href="{{ route('export.loans.csv', request()->only(['start_date', 'end_date', 'status', 'category_id'])) }}"><i class="fas fa-exchange-alt mr-2"></i>Laporan Peminjaman</a>
                </div>
            </div>
        </div>
    </div>
@stop

@section('content')
    {{-- Filter --}}
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title"><i class="fas fa-filter mr-1"></i> Filter Laporan</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
            </div>
        </div>
        <div class="card-body">
            <form action="{{ route('reports.index') }}" method="GET">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="start_date">Dari Tanggal</label>
                            <input type="date" name="start_date" id="start_date" class="form-control" value="{{ $startDate }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="end_date">Sampai Tanggal</label>
                            <input type="date" name="end_date" id="end_date" class="form-control" value="{{ $endDate }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select name="status" id="status" class="form-control">
                                <option value="">Semua Status</option>
                                <option value="borrowed" {{ $status === 'borrowed' ? 'selected' : '' }}>Dipinjam</option>
                                <option value="returned" {{ $status === 'returned' ? 'selected' : '' }}>Dikembalikan</option>
                                <option value="overdue" {{ $status === 'overdue' ? 'selected' : '' }}>Terlambat</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="category_id">Kategori</label>
                            <select name="category_id" id="category_id" class="form-control">
                                <option value="">Semua Kategori</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}" {{ $categoryId == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="d-flex">
                    <button type="submit" class="btn btn-primary mr-2"><i class="fas fa-search mr-1"></i> Terapkan Filter</button>
                    <a href="{{ route('reports.index') }}" class="btn btn-secondary"><i class="fas fa-times mr-1"></i> Reset</a>
                </div>
            </form>
        </div>
    </div>

    {{-- Info Boxes --}}
    <div class="row">
        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $totalBooks }}</h3>
                    <p>Total Buku</p>
                </div>
                <div class="icon"><i class="fas fa-book"></i></div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $totalMembers }}</h3>
                    <p>Total Anggota</p>
                </div>
                <div class="icon"><i class="fas fa-users"></i></div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ $activeLoans }}</h3>
                    <p>Sedang Dipinjam</p>
                </div>
                <div class="icon"><i class="fas fa-sign-out-alt"></i></div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>{{ $overdueLoans }}</h3>
                    <p>Terlambat</p>
                </div>
                <div class="icon"><i class="fas fa-exclamation-triangle"></i></div>
            </div>
        </div>
    </div>

    <div class="row">
        {{-- Grafik Peminjaman Bulanan --}}
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-chart-bar mr-1"></i> Peminjaman 6 Bulan Terakhir</h3>
                </div>
                <div class="card-body">
                    <canvas id="monthlyChart" height="100"></canvas>
                </div>
            </div>
        </div>

        {{-- Ringkasan Status --}}
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-chart-pie mr-1"></i> Status Peminjaman</h3>
                </div>
                <div class="card-body">
                    <canvas id="statusChart" height="200"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        {{-- Buku Paling Banyak Dipinjam --}}
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-trophy mr-1"></i> 10 Buku Terpopuler</h3>
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Judul</th>
                                <th>Penulis</th>
                                <th>Dipinjam</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($popularBooks as $book)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $book->title }}</td>
                                    <td>{{ $book->author }}</td>
                                    <td><span class="badge badge-primary">{{ $book->loans_count }}x</span></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Anggota Paling Aktif --}}
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-star mr-1"></i> 10 Anggota Teraktif</h3>
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama</th>
                                <th>Kode</th>
                                <th>Peminjaman</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($activeMembers as $member)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $member->name }}</td>
                                    <td><code>{{ $member->member_code }}</code></td>
                                    <td><span class="badge badge-success">{{ $member->loans_count }}x</span></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- Peminjaman per Kategori --}}
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-tags mr-1"></i> Peminjaman per Kategori</h3>
                </div>
                <div class="card-body">
                    <canvas id="categoryChart" height="60"></canvas>
                </div>
            </div>
        </div>
    </div>
@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4"></script>
    <script>
        // Peminjaman Bulanan
        new Chart(document.getElementById('monthlyChart'), {
            type: 'bar',
            data: {
                labels: {!! json_encode($monthlyLoans->pluck('month')) !!},
                datasets: [{
                    label: 'Jumlah Peminjaman',
                    data: {!! json_encode($monthlyLoans->pluck('total')) !!},
                    backgroundColor: 'rgba(60, 141, 188, 0.7)',
                    borderColor: 'rgba(60, 141, 188, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } },
                plugins: { legend: { display: false } }
            }
        });

        // Status Pie Chart
        new Chart(document.getElementById('statusChart'), {
            type: 'doughnut',
            data: {
                labels: ['Dipinjam', 'Dikembalikan', 'Terlambat'],
                datasets: [{
                    data: [{{ $activeLoans - $overdueLoans }}, {{ $returnedLoans }}, {{ $overdueLoans }}],
                    backgroundColor: ['#ffc107', '#28a745', '#dc3545']
                }]
            },
            options: {
                plugins: { legend: { position: 'bottom' } }
            }
        });

        // Kategori Bar Chart
        new Chart(document.getElementById('categoryChart'), {
            type: 'bar',
            data: {
                labels: {!! json_encode($loansByCategory->pluck('name')) !!},
                datasets: [{
                    label: 'Peminjaman',
                    data: {!! json_encode($loansByCategory->pluck('loans_count')) !!},
                    backgroundColor: 'rgba(40, 167, 69, 0.7)',
                    borderColor: 'rgba(40, 167, 69, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                indexAxis: 'y',
                scales: { x: { beginAtZero: true, ticks: { stepSize: 1 } } },
                plugins: { legend: { display: false } }
            }
        });
    </script>
@stop
