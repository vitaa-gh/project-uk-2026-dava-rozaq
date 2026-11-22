<?php

namespace App\Filament\Resources\TbKendaraans\Tables;

use App\Filament\Resources\TbKendaraans\Schemas\textinput;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;

use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;

class TbKendaraansTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                textcolumn::make ('plat_nomor'),
                textcolumn::make ('jenis_kendaraan'),
                textcolumn::make ('warna'),
                textcolumn::make ('pemilik'),
                

            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
