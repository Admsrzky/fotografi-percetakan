<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Pemesanan - Studio Foto & Cetak</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.10.3/dist/cdn.min.js"></script>
    <style>
        body {
            padding-bottom: 4rem; /* Agar konten tidak tertutup nav bar */
        }
        .active-nav-link {
            color: #1a202c;
        }
    </style>
</head>
<body class="bg-gray-100">

    {{-- HEADER (Tampilan Mobile) --}}
    <div class="flex items-center justify-between p-4 bg-white shadow-sm">
        <a href="{{ route('akun') }}" class="text-gray-500 hover:text-gray-700">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
        </a>
        <h1 class="text-xl font-semibold text-gray-800">Riwayat Pesanan</h1>
        <div class="w-6 h-6"></div> {{-- Placeholder untuk menjaga posisi judul di tengah --}}
    </div>

    {{-- KONTEN RIWAYAT PEMESANAN --}}
    <section class="py-8">
        <div class="container px-4 mx-auto">
            @if (session('success'))
                <div class="relative px-4 py-3 mb-4 text-green-700 bg-green-100 border border-green-400 rounded-lg">
                    <strong class="font-bold">Berhasil!</strong>
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            @if ($pemesanans->isEmpty())
                <div class="flex flex-col items-center justify-center p-8 text-center bg-white rounded-lg shadow-sm">
                    <svg class="w-24 h-24 mb-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                    </svg>
                    <p class="text-gray-600">Anda belum memiliki riwayat pemesanan.</p>
                    <div class="flex justify-center mt-8">
                        <a href="{{ route('pemesanan.form') }}"
                            class="px-6 py-3 text-sm font-semibold text-white transition duration-300 rounded-lg bg-accent hover:bg-accent-dark">
                            Buat Pemesanan Baru
                        </a>
                    </div>
                </div>
            @else
                <div class="space-y-4">
                    @foreach ($pemesanans as $pemesanan)
                        <div class="p-4 bg-white rounded-lg shadow-sm" x-data="{ open: false }">
                            <div class="flex items-center justify-between cursor-pointer" @click="open = !open">
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-800">Pemesanan #{{ $pemesanan->id }}</h3>
                                    <p class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($pemesanan->created_at)->format('d F Y') }}</p>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full @if ($pemesanan->status_pemesanan === 'pending') bg-yellow-100 text-yellow-800 @elseif ($pemesanan->status_pemesanan === 'confirmed') bg-blue-100 text-blue-800 @elseif ($pemesanan->status_pemesanan === 'completed') bg-green-100 text-green-800 @elseif ($pemesanan->status_pemesanan === 'cancelled') bg-red-100 text-red-800 @elseif ($pemesanan->status_pemesanan === 'dp') bg-purple-100 text-purple-800 @endif">
                                        {{ ucfirst($pemesanan->status_pemesanan) }}
                                    </span>
                                    <svg class="w-4 h-4 text-gray-600 transition-transform duration-300 transform" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </div>
                            </div>

                            <div class="pt-4 mt-4 border-t" x-show="open" x-collapse.duration.300ms>
                                <div class="space-y-2 text-sm text-gray-700">
                                    <p><strong>Tanggal Acara:</strong> {{ \Carbon\Carbon::parse($pemesanan->tanggal_acara)->format('d F Y') }}</p>
                                    <p><strong>Jenis Jasa:</strong> {{ ucfirst($pemesanan->jasa->tipe_jasa) }}</p>
                                    <p><strong>Paket:</strong> {{ $pemesanan->paket->nama_paket }}</p>
                                    <p><strong>Total Harga:</strong> Rp {{ number_format($pemesanan->total_harga, 0, ',', '.') }}</p>
                                    @if ($pemesanan->payment_type === 'dp')
                                    <p><strong>Jumlah DP:</strong> Rp {{ number_format($pemesanan->dp_amount, 0, ',', '.') }}</p>
                                    <p><strong>Sisa Pembayaran:</strong> Rp {{ number_format($pemesanan->remaining_payment, 0, ',', '.') }}</p>
                                    @endif
                                </div>

                                <div class="flex justify-end pt-4 mt-4 border-t">
                                    <a href="{{ route('pemesanan.invoice', $pemesanan->id) }}" target="_blank"
                                        class="inline-flex items-center px-4 py-2 text-sm font-semibold text-white transition duration-300 bg-green-500 rounded-lg hover:bg-green-600">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                        Invoice
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="mt-8">
                    {{ $pemesanans->links() }}
                </div>
            @endif
        </div>
    </section>
</body>
</html>
