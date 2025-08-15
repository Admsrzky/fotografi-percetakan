<?php

namespace App\Filament\Widgets;

use App\Models\User;
use App\Models\Pemesanan;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder; // Import Builder for nested queries

class TotalUsers extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        // Total Pemesanan
        $totalPemesanan = Pemesanan::count();

        // Total Pendapatan dari Pemesanan Keseluruhan
        $totalPendapatan = Pemesanan::sum('total_harga');

        // Pemesanan yang Belum Selesai (e.g., 'menunggu' atau 'diproses')
        $pemesananBelumSelesai = Pemesanan::whereIn('status_pemesanan', ['menunggu', 'diproses'])->count();

        // Pendapatan Bulan Ini (asumsi tanggal acara)
        $pendapatanBulanIni = Pemesanan::whereYear('tanggal_acara', Carbon::now()->year)
            ->whereMonth('tanggal_acara', Carbon::now()->month)
            ->sum('total_harga');

        // Total Pendapatan dari Percetakan
        $totalPendapatanPercetakan = Pemesanan::whereHas('jasa', function (Builder $query) {
            $query->where('tipe_jasa', 'percetakan');
        })->sum('total_harga');

        // Total Pendapatan dari Fotografi
        $totalPendapatanFotografi = Pemesanan::whereHas('jasa', function (Builder $query) {
            $query->where('tipe_jasa', 'fotografi');
        })->sum('total_harga');

        return [
            Stat::make('Total Pengguna', User::count())
                ->description('Jumlah seluruh pengguna terdaftar')
                ->descriptionIcon('heroicon-m-users')
                ->color('primary'),
            Stat::make('Pendapatan Fotografi', 'Rp ' . number_format($totalPendapatanFotografi, 0, ',', '.'))
                ->description('Total pendapatan dari jasa fotografi')
                ->descriptionIcon('heroicon-m-camera') // Ikon kamera
                ->color('warning'), // Warna berbeda untuk kategori
            Stat::make('Pendapatan Percetakan', 'Rp ' . number_format($totalPendapatanPercetakan, 0, ',', '.'))
                ->description('Total pendapatan dari jasa percetakan')
                ->descriptionIcon('heroicon-m-printer') // Ikon printer
                ->color('warning'), // Warna berbeda untuk kategori
            Stat::make('Total Pendapatan', 'Rp ' . number_format($totalPendapatan, 0, ',', '.'))
                ->description('Pendapatan keseluruhan dari semua pesanan')
                ->descriptionIcon('heroicon-m-currency-dollar')
                ->color('success'),
        ];
    }
}
