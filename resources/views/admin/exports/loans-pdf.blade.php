<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Peminjaman</title>
    <style>
        @page { margin: 30px 40px; }
        body { font-family: 'DejaVu Sans', sans-serif; font-size: 11px; color: #333; }
        .header { text-align: center; border-bottom: 3px double #333; padding-bottom: 10px; margin-bottom: 20px; }
        .header h1 { margin: 0; font-size: 20px; text-transform: uppercase; letter-spacing: 1px; }
        .header h2 { margin: 5px 0 0; font-size: 14px; font-weight: normal; color: #555; }
        .meta { display: table; width: 100%; margin-bottom: 15px; font-size: 10px; color: #666; }
        .meta .left { display: table-cell; text-align: left; }
        .meta .right { display: table-cell; text-align: right; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 15px; }
        th { background-color: #2c3e50; color: #fff; padding: 8px 6px; text-align: left; font-size: 10px; text-transform: uppercase; }
        td { padding: 7px 6px; border-bottom: 1px solid #ddd; }
        tr:nth-child(even) { background-color: #f8f9fa; }
        .status { padding: 2px 8px; border-radius: 3px; font-size: 9px; font-weight: bold; text-transform: uppercase; }
        .status-returned { background: #d4edda; color: #155724; }
        .status-borrowed { background: #fff3cd; color: #856404; }
        .status-overdue { background: #f8d7da; color: #721c24; }
        .footer { margin-top: 20px; padding-top: 10px; border-top: 1px solid #ddd; font-size: 10px; color: #999; text-align: center; }
        .summary { margin-top: 15px; font-size: 11px; }
        .summary td { border: 1px solid #ddd; padding: 5px 10px; }
        .summary th { background: #ecf0f1; color: #333; padding: 5px 10px; border: 1px solid #ddd; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Perpustakaan LibraryApp</h1>
        <h2>Laporan Data Peminjaman Buku</h2>
    </div>

    <div class="meta">
        <span class="left">Total Data: {{ $loans->count() }} transaksi</span>
        <span class="right" style="float: right;">Tanggal Cetak: {{ now()->format('d F Y, H:i') }}</span>
    </div>

    <table>
        <thead>
            <tr>
                <th width="30">No</th>
                <th>Judul Buku</th>
                <th>Anggota</th>
                <th width="75">Tgl Pinjam</th>
                <th width="75">Batas</th>
                <th width="75">Tgl Kembali</th>
                <th width="80">Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($loans as $loan)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $loan->book->title }}</td>
                    <td>{{ $loan->member->name }}</td>
                    <td>{{ $loan->loan_date->format('d/m/Y') }}</td>
                    <td>{{ $loan->due_date->format('d/m/Y') }}</td>
                    <td>{{ $loan->return_date ? $loan->return_date->format('d/m/Y') : '-' }}</td>
                    <td>
                        <span class="status status-{{ $loan->status }}">
                            @if($loan->status === 'returned') Dikembalikan
                            @elseif($loan->status === 'overdue') Terlambat
                            @else Dipinjam
                            @endif
                        </span>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <table class="summary" style="width: auto;">
        <tr>
            <th>Dipinjam</th>
            <th>Dikembalikan</th>
            <th>Terlambat</th>
        </tr>
        <tr>
            <td>{{ $loans->where('status', 'borrowed')->count() }}</td>
            <td>{{ $loans->where('status', 'returned')->count() }}</td>
            <td>{{ $loans->where('status', 'overdue')->count() }}</td>
        </tr>
    </table>

    <div class="footer">
        Dokumen ini digenerate secara otomatis oleh sistem LibraryApp &mdash; {{ now()->format('d/m/Y H:i') }}
    </div>
</body>
</html>
