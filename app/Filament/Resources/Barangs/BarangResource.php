<?php

namespace App\Filament\Resources\Barangs;

use BackedEnum;
use App\Models\Barang;
use Filament\Tables\Table;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use App\Filament\Resources\Barangs\Pages\EditBarang;
use App\Filament\Resources\Barangs\Pages\ViewBarang;
use App\Filament\Resources\Barangs\Pages\ListBarangs;
use App\Filament\Resources\Barangs\Pages\CreateBarang;
use App\Filament\Resources\Barangs\Schemas\BarangForm;
use App\Filament\Resources\Barangs\Tables\BarangsTable;
use App\Filament\Resources\Barangs\Schemas\BarangInfolist;

class BarangResource extends Resource
{
    protected static ?string $model = Barang::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
            TextInput::make('nama_barang')
                ->required()
                ->placeholder('Masukkan nama barang')
                ->label('Nama'),
            TextInput::make('kode_barang')
                ->required()
                ->label('Kode'),
            TextInput::make('harga_barang')
                ->required()
                ->numeric()
                ->label('Harga'),
              TextInput::make('stok_barang')
                ->required()
                ->label('stok_barang'),    
        ]);
    }

    public static function infolist(Schema $schema): Schema
    {
        return BarangInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nama_barang')
                    ->searchable()
                    ->sortable()
                    ->label('Nama'),
                TextColumn::make('kode_barang')
                    ->label('Kode'),
                TextColumn::make('harga_barang')
                    ->label('Harga'),
            ])
            ->filters([
                //
            ])
            ->actions([
                //
            ])
            ->bulkActions([
                //
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
            'index' => ListBarangs::route('/'),
            'create' => CreateBarang::route('/create'),
            'view' => ViewBarang::route('/{record}'),
            'edit' => EditBarang::route('/{record}/edit'),
        ];
    }
}
