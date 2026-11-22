<?php

namespace App\Filament\Resources\TbLogAktivitas;

use App\Filament\Resources\TbLogAktivitas\Pages\ManageTbLogAktivitas;
use App\Models\TbLogAktivitas;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Actions\Action;

class TbLogAktivitasResource extends Resource
{
    
    protected static ?string $model = TbLogAktivitas::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->columns([
    TextColumn::make('user.name')
        ->label('Nama Pengguna')
        ->default('-')
        ->searchable(),

    TextColumn::make('aktivitas')
        ->label('Aktivitas')
        ->searchable(),

    TextColumn::make('jenis_kendaraan')
        ->label('Jenis Kendaraan')
        ->badge()
        ->placeholder('-'),

    TextColumn::make('waktu_aktivitas')
        ->label('Waktu Aktivitas')
        ->dateTime('d-m-Y H:i:s')
        ->sortable(),
]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
    ->label('Nama User')
    ->searchable()
    ->sortable()
    ->placeholder('Tidak diketahui'),
                TextColumn::make('aktivitas')
                    ->searchable(),
                TextColumn::make('jenis_kendaraan')
                    ->badge(),
                TextColumn::make('waktu_aktivitas')
                    ->dateTime()
                    ->sortable(),
                
                
            ])
            ->filters([

            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageTbLogAktivitas::route('/'),
        ];
    }

    public static function canCreate(): bool
    {
        return false;
    }
}
