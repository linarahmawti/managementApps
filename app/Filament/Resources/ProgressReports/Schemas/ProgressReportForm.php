<?php

namespace App\Filament\Resources\ProgressReports\Schemas;

use App\Models\Assignment;
use App\Models\User;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class ProgressReportForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Assignment Information')
                    ->schema([
                        Select::make('assignment_id')
                            ->label('Assignment')
                            ->options(Assignment::all()->pluck('judul_assignment', 'id'))
                            ->searchable()
                            ->nullable()
                            ->helperText('Leave empty if this is a self-report by karyawan'),
                        Select::make('karyawan_id')
                            ->label('Karyawan')
                            ->options(User::where('role', 'karyawan')->pluck('name', 'id'))
                            ->searchable()
                            ->required(),
                    ])->columns(2),

                Section::make('Delivery Details')
                    ->schema([
                        TextInput::make('nama_barang')
                            ->label('Nama Barang')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('lokasi_pengantaran')
                            ->label('Lokasi Pengantaran')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('jumlah_diantar')
                            ->label('Jumlah Diantar')
                            ->required()
                            ->numeric()
                            ->minValue(1),
                        TextInput::make('harga_total')
                            ->label('Harga Total')
                            ->required()
                            ->numeric()
                            ->prefix('Rp')
                            ->minValue(0),
                    ])->columns(2),

                Section::make('Status & Notes')
                    ->schema([
                        Select::make('status_pengantaran')
                            ->label('Status Pengantaran')
                            ->options([
                                'belum_dikirim' => 'Belum Dikirim',
                                'dalam_perjalanan' => 'Dalam Perjalanan',
                                'selesai' => 'Selesai'
                            ])
                            ->default('belum_dikirim')
                            ->required(),
                        DateTimePicker::make('tanggal_laporan')
                            ->label('Tanggal Laporan')
                            ->required()
                            ->default(now()),
                        Textarea::make('catatan')
                            ->label('Catatan')
                            ->rows(3)
                            ->columnSpanFull(),
                    ])->columns(2),
            ]);
    }
}
