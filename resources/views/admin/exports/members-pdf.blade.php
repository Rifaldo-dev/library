<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Daftar Anggota</title>
    <style>
        @page { margin: 30px 40px; }
        body { font-family: 'DejaVu Sans', sans-serif; font-size: 11px; color: #333; }
        .header { text-align: center; border-bottom: 3px double #333; padding-bottom: 10px; margin-bottom: 20px; }
        .header h1 { margin: 0; font-size: 20px; text-transform: uppercase; letter-spacing: 1px; }
        .header h2 { margin: 5px 0 0; font-size: 14px; font-weight: normal; color: #555; }
        .meta { margin-bottom: 15px; font-size: 10px; color: #666; }
        table { width: 100%; border-collapse: collapse; }
        th { background-color: #2c3e50; color: #fff; padding: 8px 6px; text-align: left; font-size: 10px; text-transform: uppercase; }
        td { padding: 7px 6px; border-bottom: 1px solid #ddd; }
        tr:nth-child(even) { background-color: #f8f9fa; }
        .footer { margin-top: 20px; padding-top: 10px; border-top: 1px solid #ddd; font-size: 10px; color: #999; text-align: center; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Perpustakaan LibraryApp</h1>
        <h2>Daftar Anggota Perpustakaan</h2>
    </div>

    <div class="meta">
        <span>Total: {{ $members->count() }} anggota</span>
        <span style="float: right;">Tanggal Cetak: {{ now()->format('d F Y, H:i') }}</span>
    </div>

    <table>
        <thead>
            <tr>
                <th width="25">No</th>
                <th width="65">Kode</th>
                <th>Nama</th>
                <th>Email</th>
                <th width="95">Telepon</th>
                <th width="65">Bergabung</th>
                <th width="50">Pinjaman</th>
            </tr>
        </thead>
        <tbody>
            @foreach($members as $member)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $member->member_code }}</td>
                    <td>{{ $member->name }}</td>
                    <td>{{ $member->email }}</td>
                    <td>{{ $member->phone ?? '-' }}</td>
                    <td>{{ $member->joined_at->format('d/m/Y') }}</td>
                    <td>{{ $member->loans_count }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        Dokumen ini digenerate secara otomatis oleh sistem LibraryApp &mdash; {{ now()->format('d/m/Y H:i') }}
    </div>
</body>
</html>
