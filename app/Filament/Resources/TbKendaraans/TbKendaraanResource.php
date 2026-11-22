<?php

namespace App\Filament\Resources\TbKendaraans;

use App\Filament\Resources\TbKendaraans\Pages\CreateTbKendaraan;
use App\Filament\Resources\TbKendaraans\Pages\EditTbKendaraan;
use App\Filament\Resources\TbKendaraans\Pages\ListTbKendaraans;
use App\Filament\Resources\TbKendaraans\Schemas\TbKendaraanForm;
use App\Filament\Resources\TbKendaraans\Tables\TbKendaraansTable;
use App\Models\TbKendaraan;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class TbKendaraanResource extends Resource
{
    protected static ?string $model = TbKendaraan::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return TbKendaraanForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return TbKendaraansTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListTbKendaraans::route('/'),
            'create' => CreateTbKendaraan::route('/create'),
            'edit' => EditTbKendaraan::route('/{record}/edit'),
        ];
    }
}
