<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LaporanResource\Pages;
use App\Filament\Resources\LaporanResource\RelationManagers;
use App\Models\Pemesanan; // The model for the report
use Filament\Forms;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\DatePicker; // For date range filter
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn; // To display data in the table
use Filament\Tables\Columns\IconColumn; // For boolean flags
use Filament\Tables\Filters\Filter; // For custom filters like date range
use Filament\Tables\Filters\SelectFilter; // For month and year filters
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Carbon\Carbon; // For generating month and year options
use App\Filament\Exports\PemesananExporter; // Your custom exporter for Maatwebsite
use Barryvdh\DomPDF\Facade\Pdf; // Import Dompdf Facade
use Symfony\Component\HttpFoundation\BinaryFileResponse; // Import for return type

class LaporanResource extends Resource
{
    protected static ?string $model = Pemesanan::class; // Data is from Pemesanan

    protected static ?string $navigationIcon = 'heroicon-o-document-chart-bar'; // More suitable icon for reports

    protected static ?int $navigationSort = 5;

    protected static ?string $navigationGroup = 'Transaksi Management';

    protected static ?string $navigationLabel = 'Laporan Pemesanan'; // More descriptive label
    protected static ?string $pluralModelLabel = 'Laporan Pemesanan'; // Plural label

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // LaporanResource typically doesn't have a form as it's for viewing reports, not creating records.
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->sortable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('created_at') // Added 'Tanggal Pesanan' column
                    ->label('Tanggal Pesanan')
                    ->date('d M Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: false),
                TextColumn::make('nama_pelanggan')
                    ->label('Nama Pelanggan')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('jasa.nama_jasa')
                    ->label('Nama Jasa')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('paket.nama_paket')
                    ->label('Nama Paket')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('total_harga')
                    ->label('Total Harga')
                    ->money('IDR')
                    ->sortable(),
                TextColumn::make('tanggal_acara')
                    ->label('Tanggal Acara')
                    ->date('d M Y')
                    ->sortable(),
                TextColumn::make('status_pemesanan')
                    ->label('Status Pemesanan')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'menunggu' => 'warning',
                        'diproses' => 'info',
                        'selesai' => 'success',
                        'dibatalkan' => 'danger',
                        default => 'secondary',
                    })
                    ->sortable(),
                IconColumn::make('is_pelunasan_confirmed')
                    ->label('Lunas?')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-badge')
                    ->falseIcon('heroicon-o-x-mark')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('jasa_kategori')
                    ->label('Kategori Layanan')
                    ->options([
                        'percetakan' => 'Percetakan',
                        'fotografi' => 'Fotografi',
                    ])
                    ->query(function (\Illuminate\Database\Eloquent\Builder $query, array $data): \Illuminate\Database\Eloquent\Builder {
                        if (isset($data['value']) && $data['value'] !== null) {
                            $query->whereHas('jasa', function (Builder $jasaQuery) use ($data) {
                                $jasaQuery->where('tipe_jasa', $data['value']); // Menggunakan 'tipe_jasa'
                            });
                        }
                        return $query;
                    }),
                SelectFilter::make('status_pemesanan')
                    ->label('Filter Status')
                    ->options([
                        'menunggu' => 'Menunggu Konfirmasi',
                        'diproses' => 'Diproses',
                        'selesai' => 'Selesai',
                        'dibatalkan' => 'Dibatalkan',
                    ]),
                SelectFilter::make('tanggal_acara_month')
                    ->label('Bulan Acara')
                    ->options(function () {
                        $months = [];
                        for ($i = 1; $i <= 12; $i++) {
                            $months[$i] = Carbon::createFromDate(null, $i, 1)->locale('id')->monthName;
                        }
                        return $months;
                    })
                    ->query(function (Builder $query, array $data): Builder {
                        if (isset($data['value'])) {
                            $query->whereMonth('tanggal_acara', $data['value']);
                        }
                        return $query;
                    }),
                SelectFilter::make('tanggal_acara_year')
                    ->label('Tahun Acara')
                    ->options(function () {
                        $years = [];
                        $currentYear = Carbon::now()->year;
                        for ($i = $currentYear - 5; $i <= $currentYear + 5; $i++) {
                            $years[$i] = $i;
                        }
                        return $years;
                    })
                    ->query(function (Builder $query, array $data): Builder {
                        if (isset($data['value'])) {
                            $query->whereYear('tanggal_acara', $data['value']);
                        }
                        return $query;
                    }),
            ])
            ->actions([
                //
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->headerActions([
                Tables\Actions\Action::make('export_excel')
                    ->label('Export Excel')
                    ->tooltip('Download laporan pemesanan dalam format Excel (XLSX)')
                    ->color('success')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->action(function (Tables\Actions\Action $action): BinaryFileResponse {
                        // Menggunakan getLivewire() untuk mendapatkan filtered query yang benar
                        $query = $action->getTable()->getLivewire()->getFilteredTableQuery();

                        return \Maatwebsite\Excel\Facades\Excel::download(
                            new PemesananExporter($query),
                            'laporan_pemesanan_' . Carbon::now()->format('Y-m-d_His') . '.xlsx'
                        );
                    }),
                Tables\Actions\Action::make('export_pdf')
                    ->label('Export PDF')
                    ->tooltip('Download laporan pemesanan dalam format PDF')
                    ->color('danger')
                    ->icon('heroicon-o-document-arrow-down')
                    ->action(function (Tables\Actions\Action $action): \Illuminate\Http\Response|BinaryFileResponse {
                        $livewire = $action->getTable()->getLivewire();
                        $query = $livewire->getFilteredTableQuery();

                        // Ambil nilai filter dari state Livewire
                        $filters = $livewire->tableFilters;
                        $bulan = $filters['tanggal_acara_month']['value'] ?? null;
                        $tahun = $filters['tanggal_acara_year']['value'] ?? null;

                        // 2. Buat string periode berdasarkan filter
                        if ($bulan && $tahun) {
                            $startDate = \Carbon\Carbon::createFromDate($tahun, $bulan, 1)->locale('id');
                            $endDate = (clone $startDate)->endOfMonth();
                            $periode = $startDate->isoFormat('DMMMMY') . ' - ' . $endDate->isoFormat('DMMMMY');
                        } elseif ($bulan) {
                            $periode = "Bulan " . Carbon::createFromDate(null, $bulan, 1)->locale('id')->monthName;
                        } elseif ($tahun) {
                            $periode = "Tahun " . $tahun;
                        } else {
                            $periode = 'Semua Data';
                        }

                        // 3. Ambil data pemesanan dan total harga dari query yang sudah difilter
                        // Kloning query sebelum mengeksekusi agar bisa digunakan lagi
                        $pemesanans = (clone $query)->with(['pengguna', 'jasa', 'paket'])->get();
                        $totalHarga = (clone $query)->sum('total_harga');

                        // 4. Load view untuk PDF dan kirim data + periode
                        $pdf = Pdf::loadView('exports.pemesanan-pdf', compact('pemesanans', 'totalHarga', 'periode'))
                            ->setPaper('a4', 'landscape');

                        // Simpan PDF ke file sementara
                        $tmpFile = tempnam(sys_get_temp_dir(), 'pdf');
                        file_put_contents($tmpFile, $pdf->output());

                        // Unduh file PDF sebagai BinaryFileResponse
                        return response()->download(
                            $tmpFile,
                            'laporan_pemesanan_' . Carbon::now()->format('Y-m-d_His') . '.pdf'
                        )->deleteFileAfterSend(true);
                    }),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListLaporans::route('/'),
        ];
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ])
            ->with(['pengguna', 'jasa', 'paket']);
    }
}
