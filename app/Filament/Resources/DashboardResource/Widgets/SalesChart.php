<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use Carbon\Carbon;
use App\Models\Pemesanan; // Import your Pemesanan model

class SalesChart extends ChartWidget
{
    protected static ?string $heading = 'Pemesanan Bulanan'; // Changed heading to reflect Pemesanan
    protected static ?int $sort = 3;

    // Corrected: `columnSpan` should not be static if it's a dynamic property.
    // If you want it to be static, it must be `protected static int|string|array $columnSpan = 'full';`
    // If it's dynamic (e.g., depends on state), it's `protected int|string|array $columnSpan = '50%';`
    // For a chart, 'full' or '1/2' (if using tailwind grid) or '50%' are common.
    // Let's make it 'full' for a wider chart by default, or keep '50%' if you prefer it narrower.
    protected /* static */ int|string|array $columnSpan = '50%'; // Ubah dari 'static int|string|array' menjadi 'int|string|array' saja

    // Optional: Anda bisa mengatur tinggi maksimum chart jika terlihat terlalu pendek.
    // protected static ?string $maxHeight = '300px';

    protected function getType(): string
    {
        return 'line';
    }

    protected function getData(): array
    {
        $months = collect([]);
        $sales = collect([]);

        // Loop through the last 6 months (including current)
        for ($i = 5; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $months->push($month->locale('id')->isoFormat('MMM YYYY')); // Localized month format

            // Sum 'total_harga' from Pemesanan for the current month and year
            $monthlySales = Pemesanan::whereMonth('created_at', $month->month) // Assuming 'created_at' is the order creation date
                ->whereYear('created_at', $month->year)
                ->sum('total_harga'); // Use 'total_harga' from Pemesanan model

            $sales->push($monthlySales);
        }

        return [
            'datasets' => [
                [
                    'label' => 'Total Pemesanan (IDR)', // Label for the dataset
                    'data' => $sales->all(),
                    'borderColor' => '#36A2EB', // A different color for variety
                    'backgroundColor' => 'rgba(54, 162, 235, 0.2)', // Matching background color
                    'fill' => true,
                    'tension' => 0.3, // Adds a slight curve to the line
                ],
            ],
            'labels' => $months->all(),
        ];
    }

    protected function getOptions(): array
    {
        return [
            'scales' => [
                'y' => [
                    'beginAtZero' => true,
                    'ticks' => [
                        'callback' => 'function(value) { return "Rp " + value.toLocaleString("id-ID"); }', // Format Y-axis labels as IDR
                    ],
                ],
            ],
            'responsive' => true,
            'maintainAspectRatio' => false,
            'plugins' => [
                'legend' => [
                    'display' => true,
                    'position' => 'bottom',
                ],
                'tooltip' => [
                    'callbacks' => [
                        'label' => 'function(context) { return context.dataset.label + ": Rp " + context.parsed.y.toLocaleString("id-ID"); }', // Format tooltip labels
                    ],
                ],
            ]
        ];
    }
}
