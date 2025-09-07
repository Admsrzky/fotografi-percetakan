<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PortofolioResource\Pages;
use App\Filament\Resources\PortofolioResource\RelationManagers;
use App\Models\Portofolio;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

// Import komponen Filament Forms
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Repeater; // Untuk galeri jika diperlukan kontrol lebih
use Filament\Forms\Components\Section; // Untuk mengelompokkan field

// Import komponen Filament Tables
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TagsColumn; // Untuk kategori jika bisa lebih dari satu

class PortofolioResource extends Resource
{
    protected static ?string $model = Portofolio::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Produk & Jasa Management'; // Mengganti 'Settings' agar konsisten
    protected static ?string $navigationLabel = 'Data Portofolio';
    protected static ?string $pluralModelLabel = 'Data Portofolio';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Informasi Dasar Portofolio')
                    ->description('Detail utama untuk portofolio ini.')
                    ->columns(2) // Membuat layout 2 kolom di dalam section
                    ->schema([
                        Select::make('jasa_id')
                            ->relationship('jasa', 'nama_jasa') // Asumsi ada method jasa() di model Portofolio
                            ->searchable()
                            ->preload(),

                        TextInput::make('judul')
                            ->required()
                            ->maxLength(255)
                            ->columnSpan(1), // Pastikan ini hanya mengambil 1 kolom

                        Textarea::make('deskripsi')
                            ->nullable()
                            ->rows(5)
                            ->columnSpanFull(), // Membuat textarea mengambil seluruh lebar

                        Select::make('kategori') // Use Select component
                            ->options([
                                'fotografi' => 'Fotografi',
                                'percetakan' => 'Percetakan',
                            ])
                            ->required()
                            ->label('Kategori'),

                        TextInput::make('tahun')
                            ->numeric()
                            ->placeholder('Contoh: 2023')
                            ->rules(['digits:4', 'nullable']), // Validasi 4 digit untuk tahun

                        Toggle::make('unggulan')
                            ->label('Tampilkan sebagai Unggulan')
                            ->default(false),
                    ]),

                Section::make('Gambar & Galeri')
                    ->description('Atur gambar utama dan galeri pendukung untuk portofolio.')
                    ->schema([
                        FileUpload::make('gambar_utama')
                            ->label('Gambar Utama Portofolio')
                            ->directory('portofolio/utama') // Direktori penyimpanan
                            ->image() // Hanya izinkan file gambar
                            ->nullable(),

                        FileUpload::make('gambar_galeri')
                            ->label('Galeri Gambar (Bisa Multiples)')
                            ->directory('portofolio/galeri') // Direktori penyimpanan untuk galeri
                            ->multiple() // Mengizinkan banyak gambar
                            ->image() // Hanya izinkan file gambar
                            ->reorderable() // Bisa diurutkan
                            ->columnSpanFull(), // Mengambil seluruh lebar
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->sortable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true), // Sembunyikan default

                ImageColumn::make('gambar_utama')
                    ->label('Gambar Utama')
                    ->square() // Membuat gambar ditampilkan dalam kotak
                    ->size(80), // Ukuran thumbnail

                TextColumn::make('judul')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('kategori')
                    ->sortable()
                    ->searchable(),
                // Jika kategori bisa multiple dan disimpan sebagai JSON, pertimbangkan TagsColumn
                // TagsColumn::make('kategori'), // Membutuhkan casts array/collection di model

                TextColumn::make('tahun')
                    ->sortable()
                    ->searchable()
                    ->toggleable(),

                IconColumn::make('unggulan')
                    ->label('Unggulan')
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
                Tables\Filters\SelectFilter::make('kategori')
                    ->options([
                        // Isi opsi filter sesuai kategori yang ada di portofolio Anda
                        'wedding' => 'Wedding',
                        'prewedding' => 'Pre-wedding',
                        'event' => 'Event',
                        'produk' => 'Produk',
                        'lainnya' => 'Lainnya',
                    ])
                    ->label('Filter Kategori'),
                Tables\Filters\TernaryFilter::make('unggulan')
                    ->label('Tampilkan Unggulan'),
                Tables\Filters\Filter::make('tahun')
                    ->form([
                        TextInput::make('min_tahun')
                            ->numeric()
                            ->label('Dari Tahun'),
                        TextInput::make('max_tahun')
                            ->numeric()
                            ->label('Sampai Tahun'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['min_tahun'],
                                fn(Builder $query, $tahun) => $query->where('tahun', '>=', $tahun),
                            )
                            ->when(
                                $data['max_tahun'],
                                fn(Builder $query, $tahun) => $query->where('tahun', '<=', $tahun),
                            );
                    }),
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
            // Jika ada relasi seperti Tags atau Jasa, bisa ditambahkan di sini
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPortofolios::route('/'),
            'create' => Pages\CreatePortofolio::route('/create'),
            'edit' => Pages\EditPortofolio::route('/{record}/edit'),
        ];
    }

    // Optional: Untuk menyembunyikan resource dari navigasi jika sudah tidak dipakai
    // protected static bool $shouldRegisterNavigation = true;
}
