<?php

namespace App\Filament\Owner\Resources\TbTransaksis;

use App\Filament\Owner\Resources\TbTransaksis\Pages\ManageTbTransaksis;
use App\Models\TbTransaksi;
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
use App\Models\TbTarif;
use Filament\Actions\Action;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TbTransaksiResource extends Resource
{
    protected static ?string $model = TbTransaksi::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'rekap';

    protected static ?string $navigationLabel = 'Rekap Transaksi';

    protected static ?string $modelLabel = 'Rekap Transaksi';

    protected static ?string $pluralModelLabel = 'Rekap Transaksi';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('Transaksi')
            ->columns([

                TextColumn::make('kendaraan.plat_nomor')
                    ->label('Plat Nomor')
                    ->searchable(),

                TextColumn::make('areaParkir.nama_area')
                    ->label('Area Parkir'),

                TextColumn::make('waktu_masuk')
                    ->dateTime()
                    ->sortable(),

                TextColumn::make('waktu_keluar')
                    ->dateTime()
                    ->placeholder('-')
                    ->sortable(),

                TextColumn::make('durasi_jam')
                    ->placeholder('-')
                    ->sortable(),

                TextColumn::make('durasi_jam')
                    ->placeholder('-')
                    ->sortable(),

                TextColumn::make('biaya_total')
                    ->money('idr', true)
                    ->placeholder('-')
                    ->sortable(),
            ]);
    }
            
    

    public static function getPages(): array
    {
        return [
            'index' => ManageTbTransaksis::route('/'),
        ];
    }

    public static function canCreate(): bool
    {
        return false;
    }
}
