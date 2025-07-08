<?php

namespace App\Filament\Resources\CatalogoWebResource\Pages;

use App\Filament\Resources\CatalogoWebResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCatalogoWebs extends ListRecords
{
    protected static string $resource = CatalogoWebResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
