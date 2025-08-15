<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice Pemesanan #{{ $pemesanan->id }}</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        /* Custom styles for print */
        @media print {
            body {
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
            .no-print {
                display: none !important;
            }
        }
        body {
            font-family: Arial, sans-serif;
            color: #333;
        }
        .invoice-box {
            max-width: 800px;
            margin: auto;
            padding: 30px;
            border: 1px solid #eee;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
            font-size: 16px;
            line-height: 24px;
            color: #555;
            background-color: #fff;
        }
        .invoice-box table {
            width: 100%;
            line-height: inherit;
            text-align: left;
        }
        .invoice-box table td {
            padding: 5px;
            vertical-align: top;
        }
        .invoice-box table tr td:nth-child(2) {
            text-align: right;
        }
        .invoice-box table tr.top table td {
            padding-bottom: 20px;
        }
        .invoice-box table tr.top table td.title {
            font-size: 45px;
            line-height: 45px;
            color: #333;
        }
        .invoice-box table tr.information table td {
            padding-bottom: 40px;
        }
        .invoice-box table tr.heading td {
            background: #eee;
            border-bottom: 1px solid #ddd;
            font-weight: bold;
        }
        .invoice-box table tr.details td {
            padding-bottom: 20px;
        }
        .invoice-box table tr.item td {
            border-bottom: 1px solid #eee;
        }
        .invoice-box table tr.item.last td {
            border-bottom: none;
        }
        .invoice-box table tr.total td:nth-child(2) {
            border-top: 2px solid #eee;
            font-weight: bold;
        }
    </style>
</head>
<body class="p-6 bg-gray-100">
    <div class="invoice-box">
        <table cellpadding="0" cellspacing="0">
            <tr class="top">
                <td colspan="2">
                    <table>
                        <tr>
                            <td class="title">
                                {{-- Ganti dengan logo studio Anda --}}
                                <img src="{{ asset('assets/images/logo1.png') }}" style="width:100%; max-width:150px;" alt="Logo Studio">
                            </td>

                            <td>
                                Invoice #: {{ $pemesanan->id }}<br>
                                Tanggal Pesan: {{ \Carbon\Carbon::parse($pemesanan->created_at)->format('d M Y') }}<br>
                                @if ($pemesanan->tanggal_pelunasan)
                                Tanggal Pelunasan: {{ \Carbon\Carbon::parse($pemesanan->tanggal_pelunasan)->format('d M Y') }}<br>
                                @endif
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <tr class="information">
                <td colspan="2">
                    <table>
                        <tr>
                            <td>
                                Studio Foto & Cetak<br>
                                Alamat Studio Anda<br>
                                Kota, Kode Pos
                            </td>

                            <td>
                                {{ $pemesanan->pengguna->name }}<br>
                                {{ $pemesanan->email_pemesan }}<br>
                                {{ $pemesanan->telepon_pemesan }}
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <tr class="heading">
                <td>Metode Pembayaran</td>
                <td>Status Pembayaran</td>
            </tr>
            <tr class="details">
                <td>{{ $pemesanan->dp_amount > 0 && $pemesanan->dp_amount < $pemesanan->total_harga ? 'Uang Muka (DP) & Pelunasan' : 'Lunas Penuh' }}</td>
                <td>{{ ucfirst($pemesanan->status) }} @if($pemesanan->is_pelunasan_confirmed) (Pelunasan Dikonfirmasi) @endif</td>
            </tr>

            <tr class="heading">
                <td>Deskripsi Jasa</td>
                <td>Harga</td>
            </tr>

            <tr class="item">
                <td>{{ ucfirst($pemesanan->jasa->tipe_jasa) }} - Paket {{ $pemesanan->paket->nama_paket }} (Kategori: {{ $pemesanan->kategori_paket }})</td>
                <td>Rp {{ number_format($pemesanan->paket->harga_paket, 0, ',', '.') }}</td>
            </tr>
            @if ($pemesanan->quantity > 1)
            <tr class="item">
                <td>Kuantitas</td>
                <td>x{{ $pemesanan->quantity }}</td>
            </tr>
            <tr class="item">
                <td>Subtotal</td>
                <td>Rp {{ number_format($pemesanan->subtotal_harga, 0, ',', '.') }}</td>
            </tr>
            @endif

            <tr class="total">
                <td></td>
                <td>Total: Rp {{ number_format($pemesanan->total_harga, 0, ',', '.') }}</td>
            </tr>
            @if ($pemesanan->dp_amount > 0)
            <tr class="total">
                <td></td>
                <td>DP Dibayar: Rp {{ number_format($pemesanan->dp_amount, 0, ',', '.') }}</td>
            </tr>
            @endif
            @if ($pemesanan->remaining_payment > 0)
            <tr class="total">
                <td></td>
                <td>Sisa Pembayaran: Rp {{ number_format($pemesanan->remaining_payment, 0, ',', '.') }}</td>
            </tr>
            @endif
        </table>

        <div class="mt-8 text-sm text-center text-gray-600">
            <p>Terima kasih atas kepercayaan Anda.</p>
            <p>Untuk pertanyaan lebih lanjut, silakan hubungi kami.</p>
        </div>

        <div class="mt-8 text-center no-print">
            <button onclick="window.print()" class="px-4 py-2 font-bold text-white bg-blue-500 rounded hover:bg-blue-700">
                Cetak Invoice
            </button>
            <a href="{{ route('pemesanan.history') }}" class="px-4 py-2 ml-4 font-bold text-gray-800 bg-gray-300 rounded hover:bg-gray-400">
                Kembali ke Riwayat
            </a>
        </div>
    </div>
</body>
</html>
