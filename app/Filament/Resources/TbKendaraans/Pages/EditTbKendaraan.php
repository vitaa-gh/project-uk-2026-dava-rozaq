<?php

namespace App\Filament\Resources\TbKendaraans\Pages;

use App\Filament\Resources\TbKendaraans\TbKendaraanResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditTbKendaraan extends EditRecord
{
    protected static string $resource = TbKendaraanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
