<?php

namespace App\Filament\Resources\TbKendaraans\Pages;

use App\Filament\Resources\TbKendaraans\TbKendaraanResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListTbKendaraans extends ListRecords
{
    protected static string $resource = TbKendaraanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
