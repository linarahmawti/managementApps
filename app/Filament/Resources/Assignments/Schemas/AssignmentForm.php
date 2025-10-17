<?php

namespace App\Filament\Resources\Assignments\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;
use App\Models\Barang;
use App\Models\User;

class AssignmentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('barang_id')
                    ->label('Barang')
                    ->options(Barang::all()->pluck('nama_barang', 'id'))
                    ->required()
                    ->searchable()
                    ->live()
                    ->afterStateUpdated(function ($set, $state) {
                        if ($state) {
                            $barang = Barang::find($state);
                            if ($barang) {
                                $set('harga_satuan', $barang->harga_barang);
                            }
                        }
                    }),
                Select::make('karyawan_id')
                    ->label('Karyawan')
                    ->options(User::where('role', 'karyawan')->pluck('name', 'id'))
                    ->required()
                    ->searchable(),
                TextInput::make('jumlah')
                    ->label('Jumlah')
                    ->required()
                    ->numeric()
                    ->live()
                    ->afterStateUpdated(function ($get, $set, $state) {
                        $harga_satuan = $get('harga_satuan');
                        if ($harga_satuan && $state) {
                            $subtotal = $harga_satuan * $state;
                            $set('subtotal', $subtotal);
                        }
                    }),
                TextInput::make('harga_satuan')
                    ->label('Harga Satuan')
                    ->numeric()
                    ->prefix('Rp')
                    ->disabled()
                    ->dehydrated(),
                TextInput::make('subtotal')
                    ->label('Subtotal')
                    ->numeric()
                    ->prefix('Rp')
                    ->disabled()
                    ->dehydrated(),
                TextInput::make('lokasi_tujuan')
                    ->label('Lokasi Tujuan')
                    ->required()
                    ->maxLength(255),
                Select::make('status')
                    ->label('Status')
                    ->options([
                        'pending' => 'Pending',
                        'in_progress' => 'In Progress',
                        'completed' => 'Completed',
                        'cancelled' => 'Cancelled',
                    ])
                    ->default('pending')
                    ->required(),
                DatePicker::make('tanggal_assignment')
                    ->label('Tanggal Assignment')
                    ->default(now())
                    ->required(),
                Textarea::make('catatan')
                    ->label('Catatan')
                    ->columnSpanFull(),
            ]);
    }
}
