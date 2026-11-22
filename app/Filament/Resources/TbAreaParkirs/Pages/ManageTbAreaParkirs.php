<?php

namespace App\Filament\Resources\TbAreaParkirs\Pages;

use App\Filament\Resources\TbAreaParkirs\TbAreaParkirResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageTbAreaParkirs extends ManageRecords
{
    protected static string $resource = TbAreaParkirResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
