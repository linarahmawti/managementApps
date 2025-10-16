<?php

namespace App\Filament\Resources\Fakturs;

use Dom\Text;
use BackedEnum;
use App\Models\Faktur;
use Filament\Tables\Table;
use App\Models\FakturModel;
use Filament\Schemas\Schema;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Resource;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Actions\BulkDeleteAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\Fakturs\Pages\EditFaktur;
use App\Filament\Resources\Fakturs\Pages\ViewFaktur;
use App\Filament\Resources\Fakturs\Pages\ListFakturs;
use App\Filament\Resources\Fakturs\Pages\CreateFaktur;
use App\Filament\Resources\Fakturs\Schemas\FakturForm;
use App\Filament\Resources\Fakturs\Tables\FaktursTable;
use App\Filament\Resources\Fakturs\Schemas\FakturInfolist;
use Filament\Actions\DeleteAction;

class FakturResource extends Resource
{
    protected static ?string $model = FakturModel::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'Faktur';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                TextInput::make('kode_faktur')
                    ->required()
                    ->maxLength(255),
                DatePicker::make('tanggal_faktur')
                    ->required(),
                TextInput::make('kode_customer')
                    ->required()
                    ->maxLength(255),
                Select::make('customer_id')
                    ->relationship('customer', 'nama_customer')
                    ->required(),
                Textarea::make('ket_faktur')
                    ->maxLength(65535),
                TextInput::make('total')
                    ->required(),
                TextInput::make('nominal_charge')
                    ->required(),
                TextInput::make('charge')
                    ->required(),
                TextInput::make('total_final')
                    ->required(),
            ]);
    }

    public static function infolist(Schema $schema): Schema
    {
        return FakturInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('kode_faktur')->label('Kode Faktur')->searchable()->sortable(),
                TextColumn::make('tanggal_faktur')->label('Tanggal Faktur')->date()->searchable()->sortable(),
                TextColumn::make('customer.nama_customer')->label('Nama Customer')->searchable()->sortable(),
                TextColumn::make('ket_faktur')->label('Keterangan')->searchable()->sortable(),
                TextColumn::make('total')->label('Total')->money('idr', true)->searchable()->sortable(),
                TextColumn::make('nominal_charge')->label('Nominal Charge')->money('idr', true)->searchable()->sortable(),
                TextColumn::make('charge')->label('Charge (%)')->searchable()->sortable(),
                TextColumn::make('total_final')->label('Total Final')->money('idr', true)->searchable()->sortable(),
            ])
            ->filters([
                TrashedFilter::make(),
            ])
            ->actions([
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
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
            'index' => ListFakturs::route('/'),
            'create' => CreateFaktur::route('/create'),
            'view' => ViewFaktur::route('/{record}'),
            'edit' => EditFaktur::route('/{record}/edit'),
        ];
    }

    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
