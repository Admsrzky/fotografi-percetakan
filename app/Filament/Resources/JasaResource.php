<?php

namespace App\Filament\Resources;

use App\Filament\Resources\JasaResource\Pages;
use App\Filament\Resources\JasaResource\RelationManagers;
use App\Models\Jasa;
use Filament\Forms;
use Filament\Forms\Components\DateTimePicker; // Import for date/time picker
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select; // Import for select dropdown
use Filament\Forms\Components\Textarea; // Import for textarea
use Filament\Forms\Components\TextInput; // Import for text input
use Filament\Forms\Components\Toggle; // Import for toggle switch
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn; // Import for icon column
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn; // Import for text column
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class JasaResource extends Resource
{
    protected static ?string $model = Jasa::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Produk & Jasa Management';

    protected static ?string $navigationLabel = 'Data Jasa';

    protected static ?string $pluralModelLabel = 'Data Jasa';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('nama_jasa')
                    ->required()
                    ->maxLength(255),
                Select::make('tipe_jasa')
                    ->options([
                        'fotografi' => 'Fotografi',
                        'percetakan' => 'Percetakan',
                    ])
                    ->required(),
                FileUpload::make('gambar_jasa')
                    ->label('Gambar Jasa')
                    ->directory('jasa')
                    ->image()
                    ->required(),
                Textarea::make('deskripsi_jasa')
                    ->nullable(),
                Toggle::make('aktif')
                    ->label('Aktif (Active)')
                    ->default(true),
                // created_at and updated_at are typically managed by Eloquent, so not usually added to forms for manual input
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('gambar_jasa')
                    ->label('Gambar Jasa'),
                TextColumn::make('nama_jasa')
                    ->label('Nama Jasa')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('tipe_jasa')
                    ->label('Tipe Jasa')
                    ->sortable()
                    ->searchable(),
                IconColumn::make('aktif')
                    ->label('Aktif')
                    ->boolean()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label('Dibuat Pada')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true), // Hidden by default, can be toggled visible
                TextColumn::make('updated_at')
                    ->label('Diperbarui Pada')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true), // Hidden by default, can be toggled visible
            ])
            ->filters([
                // Add filters here if needed
                Tables\Filters\SelectFilter::make('tipe_jasa')
                    ->options([
                        'fotografi' => 'Fotografi',
                        'percetakan' => 'Percetakan',
                    ])
                    ->label('Filter Tipe Jasa'),
                Tables\Filters\TernaryFilter::make('aktif')
                    ->label('Filter Aktif'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(), // Added DeleteAction for individual row deletion
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
            'index' => Pages\ListJasas::route('/'),
            'create' => Pages\CreateJasa::route('/create'),
            'edit' => Pages\EditJasa::route('/{record}/edit'),
        ];
    }
}
