{{-- resources/views/filament/pages/view-pemesanan-details.blade.php --}}
@php
    use Illuminate\Support\Facades\Storage; // Pastikan ini ada jika belum diimpor secara global
@endphp

<x-filament::modal>
    <x-filament::card class="space-y-6">
        <h3 class="text-xl font-bold">Detail Pesanan #{{ $record->id }}</h3>

        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
            <div class="space-y-2">
                <p class="font-semibold text-gray-700">Nama Pelanggan:</p>
                <p>{{ $record->nama_pelanggan }}</p>

                <p class="mt-4 font-semibold text-gray-700">Email Pelanggan:</p>
                <p>{{ $record->email_pelanggan }}</p>

                <p class="mt-4 font-semibold text-gray-700">Telepon Pelanggan:</p>
                <p>{{ $record->telepon_pelanggan ?? '-' }}</p>

                <p class="mt-4 font-semibold text-gray-700">Status Pemesanan:</p>
                <x-filament::badge :color="$record->status_pemesanan === 'menunggu' ? 'warning' : ($record->status_pemesanan === 'diproses' ? 'info' : ($record->status_pemesanan === 'selesai' ? 'success' : 'danger'))">
                    {{ ucfirst($record->status_pemesanan) }}
                </x-filament::badge>
            </div>

            <div class="space-y-2">
                <p class="font-semibold text-gray-700">Jasa:</p>
                <p>{{ $record->jasa->nama_jasa ?? '-' }}</p>

                <p class="mt-4 font-semibold text-gray-700">Paket:</p>
                <p>{{ $record->paket->nama_paket ?? '-' }}</p>

                <p class="mt-4 font-semibold text-gray-700">Kategori Paket:</p>
                <p>{{ $record->kategori_paket ?? '-' }}</p>

                <p class="mt-4 font-semibold text-gray-700">Kuantitas:</p>
                <p>{{ $record->quantity }}</p>
            </div>
        </div>

        <hr>

        <h3 class="text-lg font-bold">Detail Waktu & Lokasi</h3>
        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
            <div class="space-y-2">
                <p class="font-semibold text-gray-700">Tanggal Acara:</p>
                <p>{{ $record->tanggal_acara?->format('d M Y') ?? '-' }}</p>
            </div>
            <div class="space-y-2">
                <p class="font-semibold text-gray-700">Lokasi Acara:</p>
                <p>{{ $record->lokasi_acara ?? '-' }}</p>
            </div>
        </div>

        <hr>

        <h3 class="text-lg font-bold">Informasi Pembayaran</h3>
        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
            <div class="space-y-2">
                <p class="font-semibold text-gray-700">Total Harga:</p>
                <p>Rp {{ number_format($record->total_harga, 0, ',', '.') }}</p>

                <p class="mt-4 font-semibold text-gray-700">Jumlah DP:</p>
                <p>Rp {{ number_format($record->dp_amount, 0, ',', '.') }}</p>

                <p class="mt-4 font-semibold text-gray-700">Sisa Pembayaran:</p>
                <p>Rp {{ number_format($record->remaining_payment, 0, ',', '.') }}</p>
            </div>
            <div class="space-y-2">
                <p class="font-semibold text-gray-700">Tipe Pembayaran:</p>
                <p>{{ ucfirst($record->payment_type ?? '-') }}</p>

                <p class="mt-4 font-semibold text-gray-700">Tanggal Pelunasan:</p>
                <p>{{ $record->tanggal_pelunasan?->format('d M Y H:i') ?? '-' }}</p>

                <p class="mt-4 font-semibold text-gray-700">Pelunasan Dikonfirmasi:</p>
                @if($record->is_pelunasan_confirmed)
                    <x-heroicon-o-check-circle class="inline-block w-6 h-6 text-success-500" /> Ya
                @else
                    <x-heroicon-o-x-circle class="inline-block w-6 h-6 text-danger-500" /> Tidak
                @endif
            </div>
        </div>

        <hr>

        <h3 class="text-lg font-bold">Bukti Pembayaran</h3>
        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
            {{-- Bukti Pembayaran DP/Awal --}}
            @if($record->bukti_pembayaran) {{-- Pastikan ini sesuai dengan nama kolom di DB Anda --}}
                <div class="space-y-2">
                    <p class="font-semibold text-gray-700">Bukti Pembayaran DP/Awal:</p>
                    <a href="{{ Storage::url($record->bukti_pembayaran) }}" target="_blank">
                        <img src="{{ Storage::url($record->bukti_pembayaran) }}" alt="Bukti Pembayaran DP" class="h-auto max-w-full rounded-lg shadow-md" style="max-height: 200px; object-fit: contain;">
                    </a>
                    <p class="text-sm text-gray-500">Klik gambar untuk melihat ukuran penuh.</p>
                </div>
            @else
                <div class="space-y-2">
                    <p class="font-semibold text-gray-700">Bukti Pembayaran DP/Awal:</p>
                    <p class="text-gray-500">Belum ada bukti pembayaran DP.</p>
                </div>
            @endif

            {{-- Bukti Pembayaran Pelunasan --}}
            @if($record->bukti_pelunasan_path)
                <div class="space-y-2">
                    <p class="font-semibold text-gray-700">Bukti Pembayaran Pelunasan:</p>
                    <a href="{{ Storage::url($record->bukti_pelunasan_path) }}" target="_blank">
                        <img src="{{ Storage::url($record->bukti_pelunasan_path) }}" alt="Bukti Pelunasan" class="h-auto max-w-full rounded-lg shadow-md" style="max-height: 200px; object-fit: contain;">
                    </a>
                    <p class="text-sm text-gray-500">Klik gambar untuk melihat ukuran penuh.</p>
                </div>
            @else
                <div class="space-y-2">
                    <p class="font-semibold text-gray-700">Bukti Pembayaran Pelunasan:</p>
                    <p class="text-gray-500">Belum ada bukti pelunasan.</p>
                </div>
            @endif
        </div>

        <hr>

        <h3 class="text-lg font-bold">Catatan</h3>
        <div class="space-y-2">
            <p class="font-semibold text-gray-700">Catatan dari Pelanggan:</p>
            <p>{{ $record->catatan_tambahan ?? '-' }}</p>

            <p class="mt-4 font-semibold text-gray-700">Catatan Admin:</p>
            <p>{{ $record->catatan_admin ?? '-' }}</p>
        </div>

    </x-filament::card>
</x-filament::modal>
