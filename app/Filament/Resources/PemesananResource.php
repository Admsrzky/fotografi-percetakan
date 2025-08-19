<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PemesananResource\Pages;
use App\Filament\Resources\PemesananResource\RelationManagers;
use App\Models\Pemesanan;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Infolist;

use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Storage;

class PemesananResource extends Resource
{
    protected static ?string $model = Pemesanan::class;

    protected static ?int $navigationSort = 4;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Transaksi Management';

    protected static ?string $navigationLabel = 'Pemesanan';
    protected static ?string $pluralModelLabel = 'Transaksi Pemesanan';

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->sortable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('created_at') // Added 'Tanggal Pesanan' column
                    ->label('Tanggal Pesanan')
                    ->date('d M Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: false),
                TextColumn::make('nama_pelanggan')
                    ->sortable()
                    ->searchable()
                    ->label('Nama Pelanggan'),
                TextColumn::make('pengguna.name')
                    ->label('Dipesan Oleh')
                    ->sortable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('jasa.nama_jasa')
                    ->label('Nama Jasa')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('paket.nama_paket')
                    ->label('Nama Paket')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('total_harga')
                    ->money('IDR')
                    ->sortable(),
                TextColumn::make('dp_amount')
                    ->money('IDR')
                    ->label('DP')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('remaining_payment')
                    ->money('IDR')
                    ->label('Sisa')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('tanggal_acara')
                    ->date('d M Y')
                    ->sortable(),
                TextColumn::make('payment_type')
                    ->label('Tipe Pembayaran')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('status_pemesanan')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'menunggu' => 'warning',
                        'diproses' => 'info',
                        'selesai' => 'success',
                        'dibatalkan' => 'danger',
                        default => 'secondary',
                    })
                    ->sortable(),
                IconColumn::make('bukti_pelunasan')
                    ->label('Bukti DP?')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-badge')
                    ->falseIcon('heroicon-o-x-mark')
                    ->toggleable(isToggledHiddenByDefault: true),
                IconColumn::make('is_pelunasan_confirmed')
                    ->label('Lunas?')
                    ->boolean()
                    ->getStateUsing(function (Pemesanan $record): bool {
                        // Jika payment_type adalah 'full_payment', selalu tampilkan ceklis (true)
                        if ($record->payment_type === 'full_payment') {
                            return true;
                        }
                        // Jika bukan 'full_payment', gunakan nilai is_pelunasan_confirmed yang sebenarnya
                        return (bool) $record->is_pelunasan_confirmed;
                    })
                    ->trueIcon('heroicon-o-check-badge')
                    ->falseIcon('heroicon-o-x-mark'),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('tanggal_acara_month')
                    ->label('Bulan Acara')
                    ->options(function () {
                        $months = [];
                        for ($i = 1; $i <= 12; $i++) {
                            $months[$i] = \Carbon\Carbon::createFromDate(null, $i, 1)->locale('id')->monthName;
                        }
                        return $months;
                    })
                    ->query(function (\Illuminate\Database\Eloquent\Builder $query, array $data): \Illuminate\Database\Eloquent\Builder {
                        if (isset($data['value'])) {
                            $query->whereMonth('tanggal_acara', $data['value']);
                        }
                        return $query;
                    }),

                Tables\Filters\SelectFilter::make('tanggal_acara_year')
                    ->label('Tahun Acara')
                    ->options(function () {
                        $years = [];
                        $currentYear = \Carbon\Carbon::now()->year;
                        for ($i = $currentYear - 5; $i <= $currentYear + 5; $i++) {
                            $years[$i] = $i;
                        }
                        return $years;
                    })
                    ->query(function (\Illuminate\Database\Eloquent\Builder $query, array $data): \Illuminate\Database\Eloquent\Builder {
                        if (isset($data['value'])) {
                            $query->whereYear('tanggal_acara', $data['value']);
                        }
                        return $query;
                    }),

                Tables\Filters\SelectFilter::make('jasa_kategori') // Filter based on jasa's category
                    ->label('Kategori Layanan')
                    ->options([
                        'percetakan' => 'Percetakan',
                        'fotografi' => 'Fotografi',
                    ])
                    ->query(function (\Illuminate\Database\Eloquent\Builder $query, array $data): \Illuminate\Database\Eloquent\Builder {
                        if (isset($data['value']) && $data['value'] !== null) {
                            // Mengakses kolom 'kategori' di tabel 'jasa' melalui relasi 'jasa'
                            $query->whereHas('jasa', function (Builder $jasaQuery) use ($data) {
                                $jasaQuery->where('tipe_jasa', $data['value']);
                            });
                        }
                        return $query;
                    }),

                Tables\Filters\SelectFilter::make('status_pemesanan')
                    ->options([
                        'menunggu' => 'Menunggu Konfirmasi',
                        'diproses' => 'Diproses',
                        'selesai' => 'Selesai',
                        'dibatalkan' => 'Dibatalkan',
                    ])
                    ->label('Filter Status'),
                Tables\Filters\TernaryFilter::make('is_pelunasan_confirmed')
                    ->label('Filter Pelunasan')
                    ->nullable()
                    ->trueLabel('Sudah Dikonfirmasi')
                    ->falseLabel('Belum Dikonfirmasi'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\Action::make('set_status_diproses')
                        ->label('Set Diproses')
                        ->icon('heroicon-o-arrow-path')
                        ->color('info')
                        ->visible(fn(Pemesanan $record): bool => $record->status_pemesanan === 'menunggu')
                        ->action(function (Pemesanan $record) {
                            $record->status_pemesanan = 'diproses';
                            $record->save();
                            \Filament\Notifications\Notification::make()
                                ->title('Status Pemesanan Diubah: Diproses')
                                ->success()
                                ->send();
                        }),
                    Tables\Actions\Action::make('set_status_selesai')
                        ->label('Set Selesai')
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->visible(fn(Pemesanan $record): bool => in_array($record->status_pemesanan, ['menunggu', 'diproses']))
                        ->action(function (Pemesanan $record) {
                            $record->status_pemesanan = 'selesai';
                            $record->save();
                            \Filament\Notifications\Notification::make()
                                ->title('Status Pemesanan Diubah: Selesai')
                                ->success()
                                ->send();
                        }),
                    Tables\Actions\Action::make('set_status_dibatalkan')
                        ->label('Set Dibatalkan')
                        ->icon('heroicon-o-x-circle')
                        ->color('danger')
                        ->visible(fn(Pemesanan $record): bool => !in_array($record->status_pemesanan, ['selesai', 'dibatalkan']))
                        ->action(function (Pemesanan $record) {
                            $record->status_pemesanan = 'dibatalkan';
                            $record->save();
                            \Filament\Notifications\Notification::make()
                                ->title('Status Pemesanan Diubah: Dibatalkan')
                                ->warning()
                                ->send();
                        }),
                    Tables\Actions\Action::make('konfirmasi_pelunasan')
                        ->label('Konfirmasi Pelunasan')
                        ->icon('heroicon-o-currency-dollar')
                        ->color('success')
                        ->visible(fn(Pemesanan $record): bool => !$record->is_pelunasan_confirmed && $record->payment_type === 'dp')
                        ->action(function (Pemesanan $record) {
                            $record->is_pelunasan_confirmed = true;
                            $record->tanggal_pelunasan = now();
                            $record->save();
                            \Filament\Notifications\Notification::make()
                                ->title('Pelunasan Dikonfirmasi')
                                ->success()
                                ->send();
                        })
                        ->requiresConfirmation(),
                ]),
                Tables\Actions\Action::make('download_invoice')
                    ->label('Unduh Invoice')
                    ->icon('heroicon-o-arrow-down-tray')->url(fn(Pemesanan $record) => route('filament.resources.pemesanan.download-invoice', ['record' => $record]))
                    ->openUrlInNewTab()
                    ->color('primary'),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->headerActions([]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Section::make('Informasi Pelanggan')
                    ->columns(2)
                    ->schema([
                        TextEntry::make('nama_pelanggan')->label('Nama Pelanggan'),
                        TextEntry::make('email_pelanggan')->label('Email Pelanggan'),
                        TextEntry::make('telepon_pelanggan')->label('Telepon Pelanggan')->default('-'),
                        TextEntry::make('pengguna.name')->label('Dipesan Oleh Pengguna')->default('Guest'),
                    ]),

                Section::make('Detail Layanan')
                    ->columns(2)
                    ->schema([
                        TextEntry::make('jasa.nama_jasa')->label('Jasa')->default('-'),
                        TextEntry::make('paket.nama_paket')->label('Paket')->default('-'),
                        TextEntry::make('jasa.kategori')->label('Kategori Layanan')->default('-'), // Display Jasa category
                        TextEntry::make('quantity')->label('Kuantitas'),
                        TextEntry::make('tanggal_acara')
                            ->label('Tanggal Acara')
                            ->date('d M Y')
                            ->default('-'),
                        TextEntry::make('lokasi_acara')->label('Lokasi Acara')->default('-'),
                    ]),

                Section::make('Informasi Pembayaran')
                    ->columns(2)
                    ->schema([
                        TextEntry::make('total_harga')
                            ->label('Total Harga')
                            ->money('IDR'),
                        TextEntry::make('dp_amount')
                            ->label('Jumlah DP')
                            ->money('IDR'),
                        TextEntry::make('remaining_payment')
                            ->label('Sisa Pembayaran')
                            ->money('IDR'),
                        TextEntry::make('payment_type')
                            ->label('Tipe Pembayaran')
                            ->formatStateUsing(fn(string $state) => ucfirst(str_replace('_', ' ', $state)))
                            ->default('-'),
                        TextEntry::make('tanggal_pelunasan')
                            ->label('Tanggal Pelunasan')
                            ->formatStateUsing(function (?string $state, Pemesanan $record): string {
                                if ($record->tanggal_pelunasan) {
                                    return $record->tanggal_pelunasan->format('d M Y H:i');
                                }
                                return '-';
                            }),
                        IconEntry::make('is_pelunasan_confirmed')
                            ->label('Pelunasan Dikonfirmasi')
                            ->boolean()
                            ->trueColor('success')
                            ->falseColor('danger')
                            ->trueIcon('heroicon-o-check')
                            ->falseIcon('heroicon-o-x-mark'),
                    ]),

                Section::make('Bukti Pembayaran')
                    ->columns(2)
                    ->schema([
                        TextEntry::make('bukti_pembayaran')
                            ->label('Bukti Pembayaran DP/Awal')
                            ->formatStateUsing(function (?string $state): string {
                                if (is_null($state) || empty($state)) {
                                    return 'No proof uploaded.';
                                }
                                return 'Click to View/Download Bukti Pembayaran';
                            })
                            ->url(fn(?string $state, Pemesanan $record) => $state ? Storage::url($record->bukti_pembayaran) : null, shouldOpenInNewTab: true)
                            ->color(fn(?string $state): string => is_null($state) || empty($state) ? 'gray' : 'primary'),

                        TextEntry::make('bukti_pelunasan_path')
                            ->label('Bukti Pembayaran Pelunasan')
                            ->formatStateUsing(function (?string $state): string {
                                if (is_null($state) || empty($state)) {
                                    return 'No proof uploaded.';
                                }
                                return 'Click to View/Download bukti pelunasan';
                            })
                            ->url(fn(?string $state, Pemesanan $record) => $state ? Storage::url($record->bukti_pelunasan_path) : null, shouldOpenInNewTab: true)
                            ->color(fn(?string $state): string => is_null($state) || empty($state) ? 'gray' : 'primary'),
                    ]),

                Section::make('Catatan')
                    ->schema([
                        TextEntry::make('catatan_tambahan')->label('Catatan dari Pelanggan')->default('-'),
                        TextEntry::make('catatan_admin')->label('Catatan Admin')->default('-'),
                    ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPemesanans::route('/'),
            'view' => Pages\ViewPemesanan::route('/{record}'),
        ];
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function canEdit(\Illuminate\Database\Eloquent\Model $record): bool
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

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
}
