<?php

namespace App\Filament\Resources\ProgressReports\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class ProgressReportsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('karyawan.name')
                    ->label('Karyawan')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('assignment.judul_assignment')
                    ->label('Assignment')
                    ->searchable()
                    ->sortable()
                    ->wrap(),
                TextColumn::make('nama_barang')
                    ->label('Nama Barang')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('lokasi_pengantaran')
                    ->label('Lokasi Pengantaran')
                    ->searchable()
                    ->wrap(),
                TextColumn::make('jumlah_diantar')
                    ->label('Jumlah Diantar')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('harga_total')
                    ->label('Harga Total')
                    ->money('IDR')
                    ->sortable(),
                TextColumn::make('status_pengantaran')
                    ->label('Status')
                    ->badge()
                    ->colors([
                        'success' => 'selesai',
                        'warning' => 'dalam_perjalanan',
                        'danger' => 'belum_dikirim',
                    ]),
                TextColumn::make('tanggal_laporan')
                    ->label('Tanggal Laporan')
                    ->date()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                TrashedFilter::make(),
            ])
            ->defaultSort('tanggal_laporan', 'desc')
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
            ]);
    }
}
