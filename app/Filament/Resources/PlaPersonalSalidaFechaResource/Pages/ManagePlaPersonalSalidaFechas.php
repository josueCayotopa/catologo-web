<?php

namespace App\Filament\Resources\PlaPersonalSalidaFechaResource\Pages;

use App\Filament\Resources\PlaPersonalSalidaFechaResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManagePlaPersonalSalidaFechas extends ManageRecords
{
    protected static string $resource = PlaPersonalSalidaFechaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
