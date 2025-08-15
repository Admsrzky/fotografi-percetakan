<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PaketResource\Pages;
use App\Filament\Resources\PaketResource\RelationManagers;
use App\Models\Paket;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\RichEditor;
use Filament\Tables\Columns\IconColumn;
use Filament\Forms\Get; // Import Get helper
use Filament\Forms\Set; // Import Set helper
use Illuminate\Support\Collection; // Import Collection for options


class PaketResource extends Resource
{
    protected static ?string $model = Paket::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Produk & Jasa Management';

    protected static ?string $navigationLabel = 'Paket';
    protected static ?string $pluralModelLabel = 'Paket';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make('Detail Paket')
                            ->schema([
                                TextInput::make('nama_paket')
                                    ->required()
                                    ->maxLength(255)
                                    ->placeholder('Nama Paket'),

                                Select::make('jasa_id')
                                    ->relationship('jasa', 'nama_jasa') // Pastikan relasi 'jasa' sudah ada di model Paket
                                    ->required()
                                    ->placeholder('Pilih Jasa')
                                    ->live() // Ini penting! Membuat field ini "live"
                                    ->afterStateUpdated(function (Set $set) {
                                        $set('kategori', null); // Reset kategori saat jasa_id berubah
                                    }),

                                // Select Kategori yang akan dinamis
                                Select::make('kategori')
                                    ->required()
                                    ->placeholder('Pilih Kategori Paket')
                                    ->options(function (Get $get): Collection {
                                        // Dapatkan ID Jasa yang dipilih
                                        $jasaId = $get('jasa_id');

                                        // Definisikan opsi kategori berdasarkan jasa_id
                                        // Sesuaikan ID Jasa dengan ID di database Anda
                                        $categories = [];
                                        if ($jasaId == 1) { // Misal ID Jasa 'Fotografi' adalah 1
                                            $categories = [
                                                'wedding' => 'Photo Wedding',
                                                'prewedding' => 'Photo Pre-wedding',
                                                'photosekolah' => 'Photo Sekolah',
                                                'allevent' => 'Photo All Event',
                                                'videocinematic' => 'Video Cinematic',
                                                'videoliputan' => 'Video Liputan All Event',
                                            ];
                                        } elseif ($jasaId == 2) { // Misal ID Jasa 'Percetakan' adalah 2
                                            $categories = [
                                                'cetakidcard' => 'Cetak ID Card',
                                                'cetakfoto' => 'Cetak Foto All Size',
                                                'mapijazahraport' => 'Map Ijazah dan Raport',
                                                'medalisekolah' => 'Medali Sekolah',
                                                'cetakjenisbuku' => 'Cetak Jenis Buku',
                                                'cetakstikerlabel' => 'Cetak Stiker Label Kemasan',
                                                'cetakkalender' => 'Cetak Kalender',
                                                'bingkaifoto' => 'Bingkai Foto All Size',
                                            ];
                                        }
                                        return collect($categories);
                                    })
                                    ->reactive(), // Membuat field ini "reactive" agar berubah saat jasa_id berubah

                                TextInput::make('harga_paket')
                                    ->numeric()
                                    ->prefix('Rp')
                                    ->required()
                                    ->placeholder('Harga Paket'),

                                Textarea::make('deskripsi_paket')
                                    ->nullable()
                                    ->columnSpanFull()
                                    ->placeholder('Deskripsi Paket'),

                                RichEditor::make('info_durasi')
                                    ->maxLength(255)
                                    ->nullable()
                                    ->columnSpanFull()
                                    ->placeholder('Informasi Durasi'),

                                RichEditor::make('info_output')
                                    ->maxLength(255)
                                    ->nullable()
                                    ->columnSpanFull()
                                    ->placeholder('Informasi Output'),

                                TextInput::make('urutan_tampil')
                                    ->numeric()
                                    ->default(10)
                                    ->nullable()
                                    ->placeholder('Urutan Tampil'),

                                Toggle::make('aktif')
                                    ->default(true)
                                    ->label('Aktif')
                                    ->nullable(),
                            ])->columns(2), // Sesuaikan jumlah kolom
                    ])->columnSpan(['lg' => 2]),

                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make('Timestamps')
                            ->schema([
                                Forms\Components\DateTimePicker::make('created_at')
                                    ->readOnly()
                                    ->nullable(),
                                Forms\Components\DateTimePicker::make('updated_at')
                                    ->readOnly()
                                    ->nullable(),
                            ])->hiddenOn('create'), // Hide timestamps on create form
                    ])->columnSpan(['lg' => 1]),
            ])->columns(3);
    }

    // Bagian table dan lainnya tetap sama
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nama_paket')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('jasa.nama_jasa')
                    ->label('Nama Jasa')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('kategori') // Tambahkan kolom kategori di tabel
                    ->sortable()
                    ->searchable(),
                TextColumn::make('harga_paket')
                    ->money('IDR')
                    ->sortable(),
                TextColumn::make('deskripsi_paket')
                    ->limit(50)
                    ->tooltip(function (TextColumn $column): ?string {
                        $state = $column->getState();
                        if (strlen($state) <= $column->getCharacterLimit()) {
                            return null;
                        }
                        return $state;
                    })
                    ->searchable(),
                TextColumn::make('urutan_tampil')
                    ->sortable(),
                IconColumn::make('aktif')
                    ->boolean()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('jasa_id')
                    ->relationship('jasa', 'nama_jasa')
                    ->label('Filter by Jasa'),
                SelectFilter::make('kategori') // Tambahkan filter berdasarkan kategori
                    ->options(function (): array {
                        // Anda bisa memuat semua kategori unik dari database,
                        // atau daftar statis seperti yang digunakan di form.
                        // Untuk contoh ini, kita pakai statis yang lengkap.
                        return [
                            'wedding' => 'Photo Wedding',
                            'prewedding' => 'Photo Pre-wedding',
                            'photosekolah' => 'Photo Sekolah',
                            'allevent' => 'Photo All Event',
                            'videocinematic' => 'Video Cinematic',
                            'videoliputan' => 'Video Liputan All Event',
                            'bingkaifoto' => 'Bingkai Foto All Size',
                            'cetakidcard' => 'Cetak ID Card',
                            'cetakfoto' => 'Cetak Foto All Size',
                            'mapijazahraport' => 'Map Ijazah dan Raport',
                            'medalikolah' => 'Medali Sekolah',
                            'cetakjenisbuku' => 'Cetak Jenis Buku',
                            'cetakstikerlabel' => 'Cetak Stiker Label Kemasan',
                            'cetakkalender' => 'Cetak Kalender',
                        ];
                    })
                    ->label('Filter by Kategori'),
                Tables\Filters\TernaryFilter::make('aktif')
                    ->label('Aktif')
                    ->boolean(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListPakets::route('/'),
            'create' => Pages\CreatePaket::route('/create'),
            'edit' => Pages\EditPaket::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
