<?php

namespace App\Filament\Owner\Resources\TbTransaksis\Pages;

use App\Filament\Owner\Resources\TbTransaksis\TbTransaksiResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageTbTransaksis extends ManageRecords
{
    protected static string $resource = TbTransaksiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
