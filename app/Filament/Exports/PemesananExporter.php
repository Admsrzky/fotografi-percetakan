<?php

namespace App\Filament\Exports;

use App\Models\Pemesanan;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles; // Import for styling
use Maatwebsite\Excel\Concerns\ShouldAutoSize; // Import for auto-sizing columns
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet; // Import for styling

// Add WithStyles and ShouldAutoSize interfaces
class PemesananExporter implements FromQuery, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
{
    protected Builder $query;

    public function __construct(Builder $query)
    {
        $this->query = $query;
    }

    public function query(): Builder
    {
        return $this->query->with(['pengguna', 'jasa', 'paket']);
    }

    public function headings(): array
    {
        return [
            'ID Pemesanan',
            'Nama Pelanggan',
            'Email Pelanggan',
            'Telepon Pelanggan',
            'Dipesan Oleh User',
            'Nama Jasa',
            'Nama Paket',
            'Kategori Paket',
            'Kuantitas',
            'Lokasi Acara',
            'Tanggal Acara',
            'Total Harga',
            'Jumlah DP',
            'Sisa Pembayaran',
            'Tipe Pembayaran',
            'Status Pemesanan',
            'Pelunasan Dikonfirmasi',
            'Tanggal Pelunasan',
            'Catatan Pelanggan',
            'Catatan Admin',
            'Tanggal Pesan',
            'Terakhir Diperbarui',
        ];
    }

    public function map($pemesanan): array
    {
        return [
            $pemesanan->id,
            $pemesanan->nama_pelanggan,
            $pemesanan->email_pelanggan,
            $pemesanan->telepon_pelanggan,
            $pemesanan->pengguna->name ?? 'Guest',
            $pemesanan->jasa->nama_jasa ?? '-',
            $pemesanan->paket->nama_paket ?? '-',
            $pemesanan->kategori_paket,
            $pemesanan->quantity,
            $pemesanan->lokasi_acara,
            $pemesanan->tanggal_acara ? Carbon::parse($pemesanan->tanggal_acara)->format('d M Y') : '-',
            $pemesanan->total_harga,
            $pemesanan->dp_amount,
            $pemesanan->remaining_payment,
            ucfirst(str_replace('_', ' ', $pemesanan->payment_type ?? '-')),
            ucfirst($pemesanan->status_pemesanan),
            $pemesanan->is_pelunasan_confirmed ? 'Ya' : 'Tidak',
            $pemesanan->tanggal_pelunasan ? Carbon::parse($pemesanan->tanggal_pelunasan)->format('d M Y H:i') : '-',
            $pemesanan->catatan_tambahan,
            $pemesanan->catatan_admin,
            $pemesanan->created_at ? Carbon::parse($pemesanan->created_at)->format('d M Y H:i') : '-',
            $pemesanan->updated_at ? Carbon::parse($pemesanan->updated_at)->format('d M Y H:i') : '-',
        ];
    }

    // Implement WithStyles interface method
    public function styles(Worksheet $sheet)
    {
        // Style the first row (headers)
        $sheet->getStyle('A1:' . $sheet->getHighestColumn() . '1')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['argb' => 'FFFFFFFF'], // White text
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['argb' => 'FF4F81BD'], // Dark blue background
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => 'FFCCCCCC'],
                ],
            ],
        ]);

        // Style the entire data range with borders and alignment
        $highestRow = $sheet->getHighestRow();
        $highestColumn = $sheet->getHighestColumn();
        $sheet->getStyle('A2:' . $highestColumn . $highestRow)->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => 'FFDDDDDD'],
                ],
            ],
        ]);

        // Align numeric columns to the right
        // Columns K, L, M are 'Total Harga', 'Jumlah DP', 'Sisa Pembayaran' (index 11, 12, 13 if A is 1)
        // In PHPSpreadsheet, A=1, B=2, ..., K=11, L=12, M=13
        $numericColumns = ['L', 'M', 'N']; // Corrected to L, M, N (Total Harga, DP, Sisa) if columns start from A.
        foreach ($numericColumns as $col) {
            $sheet->getStyle($col . '2:' . $col . $highestRow)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
        }
    }
}
