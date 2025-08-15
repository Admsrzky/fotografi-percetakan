<?php

namespace App\Filament\Widgets;

use Filament\Tables;
use Filament\Tables\Table; // Import kelas Table
use Filament\Widgets\TableWidget as BaseWidget; // Import BaseWidget untuk Table Widget
use App\Models\ProductTransaction; // Import model ProductTransaction Anda
use Filament\Tables\Columns\TextColumn; // Import TextColumn untuk menampilkan teks
use Filament\Tables\Filters\SelectFilter; // Opsional: Untuk filter

class LatestOrders extends BaseWidget
{
    protected static ?string $heading = 'Riwayat Pemesanan'; // Judul widget tabel, diubah agar lebih spesifik
    protected static ?int $sort = 4; // Untuk mengatur urutan, setelah chart (sort 2)

    // Penting: Agar widget ini membentang penuh di bawah chart
    protected int|string|array $columnSpan = 'full';

    // Metode ini mendefinisikan kueri untuk mengambil data tabel
    protected function getTableQuery(): \Illuminate\Database\Eloquent\Builder
    {
        // Mengambil 10 transaksi terbaru DENGAN STATUS 'completed'
        return ProductTransaction::query()
            ->where('status', 'selesai') // Tambahkan kondisi ini untuk memfilter status
            ->latest()
            ->limit(10);
    }

    // Metode ini mendefinisikan kolom-kolom yang akan ditampilkan di tabel
    protected function getTableColumns(): array
    {
        return [
            TextColumn::make('id')
                ->label('ID Pesanan')
                ->searchable()
                ->sortable(),

            // Asumsi ada relasi 'user' pada ProductTransaction ke model User
            TextColumn::make('user.name')
                ->label('Pelanggan')
                ->searchable()
                ->sortable(),

            TextColumn::make('grand_total_amount')
                ->label('Jumlah Total')
                ->money('IDR') // Format sebagai mata uang Rupiah
                ->sortable(),

            TextColumn::make('status')
                ->label('Status')
                ->badge() // Menampilkan status sebagai badge
                ->color(fn(string $state): string => match ($state) {
                    'pending' => 'warning',
                    'completed' => 'success',
                    'cancelled' => 'danger',
                    default => 'gray',
                })
                ->sortable(),

            TextColumn::make('created_at')
                ->label('Tanggal Pesanan')
                ->dateTime('d M Y, H:i') // Format tanggal dan waktu
                ->sortable(),
        ];
    }

    // Metode ini mendefikan tindakan yang tersedia di tabel (opsional)
    protected function getTableActions(): array
    {
        return [
            // Tambahkan aksi seperti melihat detail pesanan
            // Tables\Actions\ViewAction::make(),
        ];
    }

    // // Metode ini mendefinisikan filter tabel (opsional)
    // protected function getTableFilters(): array
    // {
    //     return [
    //         // Contoh filter berdasarkan status
    //         SelectFilter::make('status')
    //             ->options([
    //                 'pending' => 'Pending',
    //                 'completed' => 'Completed',
    //                 'cancelled' => 'Cancelled',
    //             ])
    //             ->label('Filter Status'),
    //     ];
    // }

    // Opsional: Untuk nonaktifkan pagination jika ingin hanya menampilkan jumlah terbatas
    protected function isTablePaginationEnabled(): bool
    {
        return false;
    }
}
