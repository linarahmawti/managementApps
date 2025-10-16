<?php

namespace App\Filament\Resources\Fakturs\Pages;

use App\Filament\Resources\Fakturs\FakturResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewFaktur extends ViewRecord
{
    protected static string $resource = FakturResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
