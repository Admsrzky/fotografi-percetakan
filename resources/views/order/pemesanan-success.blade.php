@extends('layouts.master')

@section('title', 'Pemesanan Berhasil!')

@section('content')
    <section class="py-16 bg-gray-50">
        <div class="container max-w-2xl px-4 mx-auto text-center">
            <div class="p-8 bg-white rounded-lg shadow-xl">
                <svg class="w-24 h-24 mx-auto mb-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <h2 class="mb-4 text-4xl font-bold text-green-700">Pemesanan Berhasil!</h2>
                <p class="mb-6 text-lg text-gray-700">Terima kasih telah melakukan pemesanan di studio kami.</p>

                @if (session('success'))
                    <div class="mb-4 font-semibold text-green-600">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="p-4 mb-6 text-left rounded-lg bg-green-50">
                    <h3 class="mb-2 text-xl font-semibold text-green-800">Detail Pembayaran Anda:</h3>
                    <p class="text-gray-700"><strong>Kategori:</strong> {{ $kategori ?? 'N/A' }}</p>
                    <p class="text-gray-700"><strong>Total Harga:</strong> Rp {{ number_format($totalHarga, 0, ',', '.') }}</p>
                    <p class="text-gray-700"><strong>Jumlah DP:</strong> Rp {{ number_format($dpAmount, 0, ',', '.') }}</p>
                    <p class="text-gray-700"><strong>Sisa Pembayaran:</strong> Rp {{ number_format($remainingPayment, 0, ',', '.') }}</p>
                    @if ($pemesanan)
                        <p class="text-gray-700"><strong>ID Pemesanan:</strong> {{ $pemesanan->id }}</p>
                        <p class="text-gray-700"><strong>Tanggal Acara:</strong> {{ \Carbon\Carbon::parse($pemesanan->tanggal_acara)->format('d F Y') }}</p>
                        {{-- Pastikan nama kolom status sudah benar di model Pemesanan Anda --}}
                        <p class="text-gray-700"><strong>Status:</strong> {{ ucfirst($pemesanan->status) }}</p>
                    @endif
                    <p class="mt-4 text-sm text-gray-600">Kami akan segera menghubungi Anda untuk konfirmasi lebih lanjut.</p>
                </div>

                {{-- Tombol Navigasi --}}
                <div class="flex flex-col justify-center space-y-4 sm:flex-row sm:space-y-0 sm:space-x-4">
                    <a href="{{ route('home') }}"
                        class="inline-block px-8 py-3 font-semibold text-white transition duration-300 rounded-full shadow-md bg-accent hover:bg-accent-dark">
                        Kembali ke Beranda
                    </a>
                    {{-- Tambahkan link ke riwayat pemesanan --}}
                    <a href="{{ route('history.pemesanan') }}"
                        class="inline-block px-8 py-3 font-semibold transition duration-300 border rounded-full shadow-md text-accent border-accent hover:bg-accent hover:text-white">
                        Lihat Riwayat Pemesanan
                    </a>
                </div>
            </div>
        </div>
    </section>
@endsection
