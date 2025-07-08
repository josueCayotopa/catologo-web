<?php

namespace App\Filament\Resources\CatalogoWebResource\Pages;

use App\Filament\Resources\CatalogoWebResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCatalogoWeb extends EditRecord
{
    protected static string $resource = CatalogoWebResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
