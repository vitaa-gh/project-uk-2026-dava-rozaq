<?php

namespace App\Filament\Resources\TbTarifs;

use App\Filament\Resources\TbTarifs\Pages\ManageTbTarifs;
use App\Models\TbTarif;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class TbTarifResource extends Resource
{
    protected static ?string $model = TbTarif::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'Tarif';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('jenis_kendaraan')
                    ->options(['motor' => 'Motor', 'mobil' => 'Mobil', 'lainnya' => 'Lainnya'])
                    ->required(),
                TextInput::make('tarif_per_jam')
                    ->required()
                    ->numeric(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('Tarif')
            ->columns([
                TextColumn::make('jenis_kendaraan')
                    ->badge(),
                TextColumn::make('tarif_per_jam')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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

    public static function getPages(): array
    {
        return [
            'index' => ManageTbTarifs::route('/'),
        ];
    }
}
