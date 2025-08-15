<?php

namespace App\Filament\Resources\PemesananResource\Widgets;

use App\Models\Pemesanan;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder; // Import Builder for nested queries

class PemesananOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $totalTransactions = Pemesanan::count();
        // Menggunakan 'status_pemesanan' sesuai dengan kolom di tabel Pemesanan
        $pendingTransactions = Pemesanan::where('status_pemesanan', 'menunggu')->count();
        $completedTransactions = Pemesanan::where('status_pemesanan', 'selesai')->count();
        $cancelledTransactions = Pemesanan::where('status_pemesanan', 'dibatalkan')->count();

        // Menghitung total pendapatan dari percetakan
        $totalPendapatanPercetakan = Pemesanan::whereHas('jasa', function (Builder $query) {
            $query->where('tipe_jasa', 'percetakan');
        })->sum('total_harga');

        // Menghitung total pendapatan dari fotografi
        $totalPendapatanFotografi = Pemesanan::whereHas('jasa', function (Builder $query) {
            $query->where('tipe_jasa', 'fotografi');
        })->sum('total_harga');

        return [
            Stat::make('Total Transaksi', $totalTransactions)
                ->description('Jumlah keseluruhan pesanan')
                ->descriptionIcon('heroicon-o-arrow-trending-up')
                ->color('info'), // Warna biru

            // Stat baru untuk pendapatan percetakan
            Stat::make('Pendapatan Percetakan', 'Rp ' . number_format($totalPendapatanPercetakan, 0, ',', '.'))
                ->description('Total pendapatan dari jasa percetakan')
                ->descriptionIcon('heroicon-o-printer') // Ikon printer
                ->color('success'), // Warna hijau untuk pendapatan

            // Stat baru untuk pendapatan fotografi
            Stat::make('Pendapatan Fotografi', 'Rp ' . number_format($totalPendapatanFotografi, 0, ',', '.'))
                ->description('Total pendapatan dari jasa fotografi')
                ->descriptionIcon('heroicon-o-camera') // Ikon kamera
                ->color('success'), // Warna hijau untuk pendapatan
        ];
    }
}
