<?php

namespace App\Filament\Resources\Assignments\Schemas;

use App\Models\Assignment;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class AssignmentInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('barang_id')
                    ->numeric(),
                TextEntry::make('karyawan_id')
                    ->numeric(),
                TextEntry::make('jumlah'),
                TextEntry::make('lokasi_tujuan'),
                TextEntry::make('status')
                    ->badge(),
                TextEntry::make('tanggal_assignment')
                    ->date(),
                TextEntry::make('catatan')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('deleted_at')
                    ->dateTime()
                    ->visible(fn (Assignment $record): bool => $record->trashed()),
            ]);
    }
}
