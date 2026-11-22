<?php

namespace App\Filament\Resources\TbKendaraans\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;


class TbKendaraanForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make ('plat_nomor')
                    ->required(),
                Select::make('jenis_kendaraan')
                    ->options(['motor' => 'Motor', 'mobil' => 'Mobil', 'lainnya' => 'Lainnya'])
                    ->required(),
                TextInput::make ('warna')
                    ->required(),
                TextInput::make ('pemilik')
                    ->required(),
            ]);
    }
}
