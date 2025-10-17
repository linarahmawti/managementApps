<?php

namespace App\Filament\Resources\ProgressReports\Schemas;

use App\Models\ProgressReport;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\BadgeEntry;
use Filament\Schemas\Schema;

class ProgressReportInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Assignment Information')
                    ->schema([
                        TextEntry::make('assignment.judul_assignment')
                            ->label('Assignment')
                            ->placeholder('Self Report'),
                        TextEntry::make('karyawan.name')
                            ->label('Karyawan'),
                    ])->columns(2),

                Section::make('Delivery Details')
                    ->schema([
                        TextEntry::make('nama_barang')
                            ->label('Nama Barang'),
                        TextEntry::make('lokasi_pengantaran')
                            ->label('Lokasi Pengantaran'),
                        TextEntry::make('jumlah_diantar')
                            ->label('Jumlah Diantar')
                            ->numeric(),
                        TextEntry::make('harga_total')
                            ->label('Harga Total')
                            ->money('IDR'),
                    ])->columns(2),

                Section::make('Status & Timeline')
                    ->schema([
                        BadgeEntry::make('status_pengantaran')
                            ->label('Status')
                            ->colors([
                                'success' => 'selesai',
                                'warning' => 'dalam_perjalanan',
                                'danger' => 'belum_dikirim',
                            ]),
                        TextEntry::make('tanggal_laporan')
                            ->label('Tanggal Laporan')
                            ->dateTime(),
                        TextEntry::make('catatan')
                            ->label('Catatan')
                            ->placeholder('Tidak ada catatan')
                            ->columnSpanFull(),
                    ])->columns(2),

                Section::make('System Information')
                    ->schema([
                        TextEntry::make('created_at')
                            ->label('Dibuat')
                            ->dateTime(),
                        TextEntry::make('updated_at')
                            ->label('Diupdate')
                            ->dateTime(),
                    ])->columns(2)
                    ->collapsible()
                    ->collapsed(true),
            ]);
    }
}
