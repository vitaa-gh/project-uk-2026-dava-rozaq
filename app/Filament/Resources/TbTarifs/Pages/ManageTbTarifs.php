<?php

namespace App\Filament\Resources\TbTarifs\Pages;

use App\Filament\Resources\TbTarifs\TbTarifResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageTbTarifs extends ManageRecords
{
    protected static string $resource = TbTarifResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
