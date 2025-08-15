<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use Carbon\Carbon;
use App\Models\Pemesanan; // Import model Pemesanan Anda

class WeeklySalesChart extends ChartWidget // Mengubah nama kelas agar lebih deskriptif
{
    protected static ?string $heading = 'Grafik Pendapatan Pemesanan Harian'; // Judul chart disesuaikan
    protected static ?int $sort = 2; // Urutan widget

    // Mengatur lebar kolom chart. 'full' akan mengambil seluruh lebar yang tersedia.

    protected function getType(): string
    {
        return 'line'; // Diubah menjadi 'line' untuk chart garis
    }

    protected function getData(): array
    {
        $labels = collect([]);
        $dataCabangA = collect([]);
        $dataCabangB = collect([]); // Untuk simulasi "Cabang B"

        // Ambil data untuk 5 hari terakhir (sesuai contoh gambar)
        // Anda bisa menyesuaikan rentang hari sesuai kebutuhan
        for ($i = 4; $i >= 0; $i--) { // Loop dari 4 hari yang lalu hingga hari ini
            $date = Carbon::now()->subDays($i);
            $labels->push($date->format('d M')); // Format label sumbu X (misal: 1 Nov)

            // Data untuk "Cabang A" (menggunakan data asli dari Pemesanan)
            $dailySalesA = Pemesanan::whereDate('created_at', $date) // Menggunakan 'created_at' untuk tanggal transaksi
                ->sum('total_harga'); // Menggunakan 'total_harga' sebagai pendapatan

            $dataCabangA->push($dailySalesA);

            // Simulasi data untuk "Cabang B"
            // Dalam aplikasi nyata, ini akan menjadi query terpisah untuk Cabang B
            // Contoh: mengambil 80-120% dari Cabang A untuk simulasi variasi
            $dailySalesB = $dailySalesA * (rand(80, 120) / 100);
            $dataCabangB->push($dailySalesB);
        }

        return [
            'datasets' => [
                [
                    'label' => 'Cabang A', // Label untuk dataset pertama
                    'data' => $dataCabangA->all(),
                    'borderColor' => '#00B894', // Warna hijau kebiruan (seperti di gambar)
                    'backgroundColor' => 'rgba(0, 184, 148, 0.2)', // Warna latar belakang transparan
                    'fill' => false, // Tidak mengisi area di bawah garis
                    'tension' => 0.4, // Membuat garis sedikit melengkung
                ],
                [
                    'label' => 'Cabang B', // Label untuk dataset kedua
                    'data' => $dataCabangB->all(),
                    'borderColor' => '#0984E3', // Warna biru (seperti di gambar)
                    'backgroundColor' => 'rgba(9, 132, 227, 0.2)',
                    'fill' => false,
                    'tension' => 0.4,
                ],
            ],
            'labels' => $labels->all(),
        ];
    }

    protected function getOptions(): array
    {
        return [
            'scales' => [
                'y' => [
                    'beginAtZero' => true,
                    'ticks' => [
                        // Callback untuk memformat label sumbu Y sebagai mata uang IDR dengan "juta" jika nilai besar
                        'callback' => 'function(value) {
                            if (value >= 1000000) {
                                return "Rp " + (value / 1000000).toLocaleString("id-ID") + " juta";
                            } else if (value >= 1000) {
                                return "Rp " + (value / 1000).toLocaleString("id-ID") + " rb";
                            }
                            return "Rp " + value.toLocaleString("id-ID");
                        }',
                    ],
                ],
            ],
            'responsive' => true,
            'maintainAspectRatio' => false,
            'plugins' => [
                'legend' => [
                    'display' => true,
                    'position' => 'bottom', // Legenda di bawah chart
                ],
                'tooltip' => [
                    'callbacks' => [
                        // Callback untuk memformat label tooltip sebagai mata uang IDR
                        'label' => 'function(context) {
                            return context.dataset.label + ": Rp " + context.parsed.y.toLocaleString("id-ID");
                        }',
                    ],
                ],
            ]
        ];
    }
}
