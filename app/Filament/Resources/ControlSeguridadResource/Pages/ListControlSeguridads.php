<?php

namespace App\Filament\Resources\ControlSeguridadResource\Pages;

use App\Filament\Resources\ControlSeguridadResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListControlSeguridads extends ListRecords
{
    protected static string $resource = ControlSeguridadResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
