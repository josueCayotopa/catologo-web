<?php

namespace App\Filament\Resources\PlaPersonalSalidaResource\Pages;

use App\Filament\Resources\PlaPersonalSalidaResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManagePlaPersonalSalidas extends ManageRecords
{
    protected static string $resource = PlaPersonalSalidaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
