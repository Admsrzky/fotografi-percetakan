<!DOCTYPE html>
<html>
<head>
    <title>Laporan Data Pemesanan Re-Project</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            font-size: 10px;
            margin: 40px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 25px;
        }
        th, td {
            border: 1px solid #e0e0e0;
            padding: 10px 8px;
            text-align: left;
            vertical-align: top;
        }
        th {
            background-color: #f5f5f5;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 9px;
        }
        h1 {
            text-align: center;
            color: #333;
            font-size: 20px;
            margin-bottom: 5px;
        }
        h2 {
            text-align: center;
            color: #555;
            font-size: 14px;
            margin-top: 0;
            margin-bottom: 25px;
        }
        .report-info {
            text-align: center;
            margin-bottom: 20px;
            font-size: 10px;
            color: #666;
        }
        .text-center {
            text-align: center;
        }
        .text-right {
            text-align: right;
        }
        .total-row strong {
            font-size: 11px;
            color: #000;
        }
        .signature-section {
            margin-top: 50px;
            display: block; /* Ensure it takes full width for alignment */
            width: 100%;
            text-align: right;
        }
        .signature-box {
            display: inline-block;
            text-align: center;
            margin-right: 50px; /* Adjust spacing from right if needed */
        }
        .signature-line {
            border-top: 1px solid #000;
            width: 150px; /* Width of the signature line */
            margin-top: 50px; /* Space for signature */
            margin-bottom: 5px;
            display: block;
        }
        .signature-name {
            font-weight: bold;
            font-size: 11px;
            margin-bottom: 2px;
        }
        .signature-title {
            font-size: 9px;
            color: #555;
        }
    </style>
</head>
<body>
    <h1>Laporan Data Pemesanan</h1>
    <h2>Re-Project</h2>
    <div class="report-info">
        <p>Tanggal Cetak: **{{ \Carbon\Carbon::now()->locale('id')->isoFormat('dddd, D MMMM YYYY HH:mm') }} WIB**</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama Pelanggan</th>
                <th>Email</th>
                <th>Telepon</th>
                <th>Dipesan Oleh</th>
                <th>Jasa</th>
                <th>Paket</th>
                <th>Kategori</th>
                <th>Qty</th>
                <th>Lokasi Acara</th>
                <th>Tgl Acara</th>
                <th>Total Harga (IDR)</th>
                <th>DP (IDR)</th>
                <th>Sisa (IDR)</th>
                <th>Tipe Bayar</th>
                <th>Status</th>
                <th>Lunas?</th>
                <th>Tgl Pelunasan</th>
                <th>Catatan Pelanggan</th>
                <th>Catatan Admin</th>
                <th>Tgl Pesan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pemesanans as $record)
            <tr>
                <td>{{ $record->id }}</td>
                <td>{{ $record->nama_pelanggan }}</td>
                <td>{{ $record->email_pelanggan }}</td>
                <td>{{ $record->telepon_pelanggan }}</td>
                <td>{{ $record->pengguna->name ?? 'Guest' }}</td>
                <td>{{ $record->jasa->nama_jasa ?? '-' }}</td>
                <td>{{ $record->paket->nama_paket ?? '-' }}</td>
                <td>{{ $record->kategori_paket ?? '-' }}</td>
                <td>{{ $record->quantity }}</td>
                <td>{{ $record->lokasi_acara ?? '-' }}</td>
                <td>{{ $record->tanggal_acara?->format('d M Y') ?? '-' }}</td>
                <td class="text-right">{{ number_format($record->total_harga, 0, ',', '.') }}</td>
                <td class="text-right">{{ number_format($record->dp_amount, 0, ',', '.') }}</td>
                <td class="text-right">{{ number_format($record->remaining_payment, 0, ',', '.') }}</td>
                <td>{{ ucfirst(str_replace('_', ' ', $record->payment_type ?? '-')) }}</td>
                <td>{{ ucfirst($record->status_pemesanan) }}</td>
                <td>{{ $record->is_pelunasan_confirmed ? 'Ya' : 'Tidak' }}</td>
                <td>{{ $record->tanggal_pelunasan?->format('d M Y H:i') ?? '-' }}</td>
                <td>{{ $record->catatan_tambahan ?? '-' }}</td>
                <td>{{ $record->catatan_admin ?? '-' }}</td>
                <td>{{ $record->created_at?->format('d M Y H:i') ?? '-' }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr class="total-row">
                <td colspan="11" class="text-right"><strong>Total Keseluruhan Harga:</strong></td>
                <td class="text-right"><strong>{{ number_format($totalHarga, 0, ',', '.') }}</strong></td>
                <td colspan="9"></td> {{-- Remaining columns after total harga --}}
            </tr>
        </tfoot>
    </table>

    <div class="signature-section">
        <div class="signature-box">
            <p class="signature-name">Manager Re-Project</p>
            <span class="signature-line"></span>
            <p class="signature-name">Reza Adya Pratama</p> {{-- Placeholder for manager's name --}}
            <p class="signature-title">Owner</p> {{-- Optional: manager's title --}}
        </div>
    </div>
</body>
</html>
