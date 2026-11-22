<?php

namespace App\Filament\Resources\TbLogAktivitas\Pages;

use App\Filament\Resources\TbLogAktivitas\TbLogAktivitasResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageTbLogAktivitas extends ManageRecords
{
    protected static string $resource = TbLogAktivitasResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
