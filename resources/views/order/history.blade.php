@extends('layouts.master') {{-- Sesuaikan dengan layout utama Anda --}}

@section('title', 'Riwayat Pemesanan Anda')

@section('content')
    <section class="min-h-screen py-16 bg-gray-50">
        <div class="container max-w-5xl px-4 mx-auto">
            <h2 class="mb-8 text-4xl font-bold text-center text-gray-800">Riwayat Pemesanan Anda</h2>

            @if (session('success'))
                <div class="relative px-4 py-3 mb-4 text-green-700 bg-green-100 border border-green-400 rounded-xl"
                    role="alert">
                    <strong class="font-bold">Berhasil!</strong>
                    <span class="block sm:inline">{{ session('success') }}</span>
                    <span class="absolute top-0 bottom-0 right-0 px-4 py-3 cursor-pointer"
                        onclick="this.parentElement.style.display='none';">
                        <svg class="w-6 h-6 text-green-500 fill-current" role="button" xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 20 20">
                            <title>Close</title>
                            <path
                                d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.304l-2.651 3.545a1.2 1.2 0 1 1-1.697-1.697l3.545-2.651-3.545-2.651a1.2 1.2 0 1 1 1.697-1.697L10 8.696l2.651-3.545a1.2 1.2 0 1 1 1.697 1.697L11.304 10l3.545 2.651a1.2 1.2 0 0 1 0 1.697z" />
                        </svg>
                    </span>
                </div>
            @endif

            @if (session('error'))
                <div class="relative px-4 py-3 mb-4 text-red-700 bg-red-100 border border-red-400 rounded-xl"
                    role="alert">
                    <strong class="font-bold">Gagal!</strong>
                    <span class="block sm:inline">{{ session('error') }}</span>
                    <span class="absolute top-0 bottom-0 right-0 px-4 py-3 cursor-pointer"
                        onclick="this.parentElement.style.display='none';">
                        <svg class="w-6 h-6 text-red-500 fill-current" role="button" xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 20 20">
                            <title>Close</title>
                            <path
                                d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.304l-2.651 3.545a1.2 1.2 0 1 1-1.697-1.697l3.545-2.651-3.545-2.651a1.2 1.2 0 1 1 1.697-1.697L10 8.696l2.651-3.545a1.2 1.2 0 1 1 1.697 1.697L11.304 10l3.545 2.651a1.2 1.2 0 0 1 0 1.697z" />
                        </svg>
                    </span>
                </div>
            @endif

            @if ($errors->any())
                <div class="relative px-4 py-3 mb-4 text-red-700 bg-red-100 border border-red-400 rounded-xl"
                    role="alert">
                    <strong class="font-bold">Oops!</strong>
                    <span class="block sm:inline">Ada beberapa masalah dengan unggahan Anda.</span>
                    <ul class="mt-3 list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <span class="absolute top-0 bottom-0 right-0 px-4 py-3 cursor-pointer"
                        onclick="this.parentElement.style.display='none';">
                        <svg class="w-6 h-6 text-red-500 fill-current" role="button" xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 20 20">
                            <title>Close</title>
                            <path
                                d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.304l-2.651 3.545a1.2 1.2 0 1 1-1.697-1.697l3.545-2.651-3.545-2.651a1.2 1.2 0 1 1 1.697-1.697L10 8.696l2.651-3.545a1.2 1.2 0 1 1 1.697 1.697L11.304 10l3.545 2.651a1.2 1.2 0 0 1 0 1.697z" />
                        </svg>
                    </span>
                </div>
            @endif

            @if ($pemesanans->isEmpty())
                <p class="text-center text-gray-600">Anda belum memiliki riwayat pemesanan.</p>
                <div class="flex justify-center mt-8">
                    <a href="{{ route('pemesanan.form') }}" {{-- Pastikan route ini benar --}}
                        class="px-6 py-3 text-lg font-semibold text-white transition duration-300 rounded-full bg-accent hover:bg-accent-dark">
                        Buat Pemesanan Baru
                    </a>
                </div>
            @else
                <div class="space-y-6">
                    @foreach ($pemesanans as $pemesanan)
                        <div class="p-6 bg-white border border-gray-100 rounded-lg shadow-lg">
                            {{-- Header Pemesanan (untuk toggle) --}}
                            <div class="flex items-center justify-between pb-4 mb-4 cursor-pointer header-toggle"
                                data-target="#detail-{{ $pemesanan->id }}">
                                <div>
                                    <h3 class="text-xl font-semibold text-gray-800">Pemesanan #{{ $pemesanan->id }}</h3>
                                    <p class="text-sm text-gray-600">Tanggal Pemesanan:
                                        {{ \Carbon\Carbon::parse($pemesanan->created_at)->format('d F Y H:i') }}</p>
                                </div>
                                <div class="flex items-center space-x-3">
                                    {{-- Debugging: Tampilkan nilai status yang sebenarnya --}}
                                    {{-- <p class="text-xs text-red-500">Status DB: "{{ $pemesanan->status }}"</p> --}}

                                    <span
                                        class="px-3 py-1 text-sm font-semibold rounded-full
                                        @if ($pemesanan->status_pemesanan === 'pending') bg-yellow-100 text-yellow-800
                                        @elseif ($pemesanan->status_pemesanan === 'confirmed') bg-blue-100 text-blue-800
                                        @elseif ($pemesanan->status_pemesanan === 'completed') bg-green-100 text-green-800
                                        @elseif ($pemesanan->status_pemesanan === 'cancelled') bg-red-100 text-red-800
                                        @elseif ($pemesanan->status_pemesanan === 'dp') bg-purple-100 text-purple-800 @endif
                                    ">
                                        {{ ucfirst($pemesanan->status_pemesanan) }}
                                    </span>
                                    <svg class="w-5 h-5 text-gray-600 transition-transform duration-300 transform arrow-icon"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </div>
                            </div>

                            {{-- Detail Pemesanan (konten yang akan di-toggle) --}}
                            <div id="detail-{{ $pemesanan->id }}" class="hidden content-toggle">
                                <div class="grid grid-cols-1 gap-4 text-gray-700 md:grid-cols-2">
                                    <div>
                                        <p><strong class="text-gray-800">Tanggal Acara:</strong>
                                            {{ \Carbon\Carbon::parse($pemesanan->tanggal_acara)->format('d F Y') }}</p>
                                        <p><strong class="text-gray-800">Jenis Jasa:</strong>
                                            {{ ucfirst($pemesanan->jasa->tipe_jasa) }}</p>
                                        <p><strong class="text-gray-800">Paket:</strong>
                                            {{ $pemesanan->paket->nama_paket }}</p>
                                        <p><strong class="text-gray-800">Kategori:</strong>
                                            {{ $pemesanan->kategori_paket }}</p>
                                    </div>
                                    <div>
                                        <p><strong class="text-gray-800">Harga Paket:</strong>
                                            Rp {{ number_format($pemesanan->paket->harga_paket, 0, ',', '.') }}</p>
                                        @if ($pemesanan->quantity > 1)
                                            <p><strong class="text-gray-800">Kuantitas:</strong>
                                                {{ $pemesanan->quantity }}</p>
                                            <p><strong class="text-gray-800">Subtotal:</strong>
                                                Rp {{ number_format($pemesanan->subtotal_harga, 0, ',', '.') }}</p>
                                        @endif
                                        <p><strong class="text-gray-800">Total Harga:</strong>
                                            Rp {{ number_format($pemesanan->total_harga, 0, ',', '.') }}</p>
                                        <p><strong class="text-gray-800">Jumlah DP:</strong>
                                            Rp {{ number_format($pemesanan->dp_amount, 0, ',', '.') }}</p>
                                        <p><strong class="text-gray-800">Sisa Pembayaran:</strong>
                                            Rp {{ number_format($pemesanan->remaining_payment, 0, ',', '.') }}</p>
                                    </div>
                                </div>

                                <div class="pt-4 mt-4 border-t">
                                    <p><strong class="text-gray-800">Lokasi/Alamat:</strong>
                                        {{ $pemesanan->lokasi_acara }}</p>
                                    <p><strong class="text-gray-800">Catatan:</strong>
                                        {{ $pemesanan->catatan ?? 'Tidak ada catatan.' }}</p>
                                </div>

                                {{-- Tampilkan bukti DP jika ada --}}
                                @if ($pemesanan->bukti_dp_path)
                                    <div class="pt-4 mt-4 border-t">
                                        <p class="font-semibold text-gray-800">Bukti Pembayaran DP:</p>
                                        <a href="{{ Storage::url($pemesanan->bukti_dp_path) }}" target="_blank"
                                            class="text-blue-600 hover:underline">Lihat Bukti DP</a>
                                    </div>
                                @endif

                                {{-- Form Upload Bukti Pelunasan jika status "DP" dan belum ada bukti pelunasan yang dikonfirmasi --}}
                                {{-- Penambahan kondisi: is_pelunasan_confirmed harus false UNTUK MENAMPILKAN FORM --}}
                                @if ($pemesanan->payment_type === 'dp' && !$pemesanan->is_pelunasan_confirmed)
                                    <div class="p-4 mt-6 border border-blue-200 rounded-lg bg-blue-50">
                                        <h4 class="mb-3 text-lg font-semibold text-blue-800">Unggah Bukti Pelunasan</h4>
                                        <p class="mb-4 text-sm text-blue-700">Silakan unggah bukti transfer untuk pelunasan
                                            pemesanan ini.</p>
                                        <form action="{{ route('pemesanan.upload_pelunasan', $pemesanan->id) }}"
                                            method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <div class="mb-4">
                                                <label for="bukti_pelunasan_{{ $pemesanan->id }}"
                                                    class="block mb-2 text-sm font-semibold text-gray-800">Pilih File Bukti
                                                    Pelunasan</label>
                                                <input type="file" id="bukti_pelunasan_{{ $pemesanan->id }}"
                                                    name="bukti_pelunasan"
                                                    class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-100 file:text-blue-700 hover:file:bg-blue-200"
                                                    required>
                                                @error('bukti_pelunasan')
                                                    <p class="mt-1 text-xs italic text-red-500">{{ $message }}</p>
                                                @enderror
                                                <p class="mt-1 text-xs text-gray-500">Max: 2MB, Format: JPG, PNG, GIF</p>
                                            </div>
                                            <button type="submit"
                                                class="px-5 py-2 text-sm font-semibold text-white transition duration-300 bg-blue-600 rounded-lg hover:bg-blue-700">
                                                Unggah Pelunasan
                                            </button>
                                        </form>
                                    </div>
                                @endif

                                {{-- Tampilkan bukti pelunasan jika sudah ada (baik sudah dikonfirmasi atau belum) --}}
                                @if ($pemesanan->bukti_pelunasan_path)
                                    <div class="pt-4 mt-4 border-t">
                                        <p class="font-semibold text-gray-800">Bukti Pelunasan:</p>
                                        <a href="{{ Storage::url($pemesanan->bukti_pelunasan_path) }}" target="_blank"
                                            class="text-blue-600 hover:underline">Lihat Bukti Pelunasan</a>
                                        {{-- Tampilkan pesan menunggu konfirmasi hanya jika status masih 'dp' DAN belum dikonfirmasi --}}
                                        @if ($pemesanan->status === 'dp' && !$pemesanan->is_pelunasan_confirmed)
                                            <p class="mt-1 text-sm text-yellow-600">Bukti pelunasan telah diunggah,
                                                menunggu konfirmasi admin.</p>
                                        @elseif ($pemesanan->is_pelunasan_confirmed)
                                            <p class="mt-1 text-sm text-green-600">Pelunasan telah dikonfirmasi oleh admin. ✅</p>
                                        @endif
                                        @if ($pemesanan->tanggal_pelunasan)
                                            <p class="mt-1 text-sm text-gray-600">Tanggal Pelunasan:
                                                {{ \Carbon\Carbon::parse($pemesanan->tanggal_pelunasan)->format('d F Y H:i') }}
                                            </p>
                                        @endif
                                    </div>
                                @endif

                                {{-- Tombol Download Invoice --}}
                                <div class="flex justify-end pt-4 mt-4 border-t">
                                    <a href="{{ route('pemesanan.invoice', $pemesanan->id) }}" target="_blank"
                                        class="inline-flex items-center px-4 py-2 text-sm font-semibold text-white transition duration-300 bg-green-500 rounded-lg hover:bg-green-600">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                            </path>
                                        </svg>
                                        Download Invoice
                                    </a>
                                </div>

                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="mt-8">
                    {{ $pemesanans->links() }} {{-- Jika menggunakan pagination --}}
                </div>
            @endif
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.header-toggle').forEach(header => {
                header.addEventListener('click', function() {
                    const targetId = this.dataset.target;
                    const content = document.querySelector(targetId);
                    const arrowIcon = this.querySelector('.arrow-icon');

                    if (content.classList.contains('hidden')) {
                        content.classList.remove('hidden');
                        arrowIcon.classList.add('rotate-180');
                    } else {
                        content.classList.add('hidden');
                        arrowIcon.classList.remove('rotate-180');
                    }
                });
            });
        });
    </script>
@endpush
