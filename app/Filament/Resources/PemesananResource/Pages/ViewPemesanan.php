<?php

namespace App\Filament\Resources\PemesananResource\Pages;

use App\Filament\Resources\PemesananResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Database\Eloquent\Builder;

class ViewPemesanan extends ViewRecord
{
    protected static string $resource = PemesananResource::class;

    // Use the default record route key name, no explicit definition needed unless changed
    // protected static ?string $recordRouteKeyName = 'record';

    /**
     * Get the query builder for the record.
     * This method is called by Filament to retrieve the record to display.
     * We'll use it to eager load the necessary relationships.
     */
    protected function getTableQuery(): Builder
    {
        // Start with the base query defined in the resource (which already handles soft deletes)
        return PemesananResource::getEloquentQuery()
            // Eager load the relationships that are used in the infolist.
            // Based on your PemesananResource's infolist:
            // - user (for user.name)
            // - jasa (for jasa.nama_jasa)
            // - paket (for paket.nama_paket)
            // - No 'items' relationship for Pemesanan in your provided infolist.
            //   If Pemesanan also has items, ensure that relationship is loaded.
            ->with(['pengguna', 'jasa', 'paket']);
    }


    protected function getHeaderActions(): array
    {
        return [
            // If you decide to allow editing from the view page, uncomment this:
            // Actions\EditAction::make(),
        ];
    }
}
