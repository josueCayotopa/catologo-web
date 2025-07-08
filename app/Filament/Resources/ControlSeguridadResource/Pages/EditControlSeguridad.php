<?php

namespace App\Filament\Resources\ControlSeguridadResource\Pages;

use App\Filament\Resources\ControlSeguridadResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditControlSeguridad extends EditRecord
{
    protected static string $resource = ControlSeguridadResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
