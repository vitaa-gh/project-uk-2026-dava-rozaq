<?php

namespace App\Filament\Petugas\Resources\TbTransaksis;

use App\Filament\Petugas\Resources\TbTransaksis\Pages\ManageTbTransaksis;
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
use App\Models\TbKendaraan;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Illuminate\Database\Eloquent\Builder;

class TbTransaksiResource extends Resource
{
    protected static ?string $model = TbTransaksi::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'Transaksi';

    public static function form(Schema $schema): Schema
{
    return $schema
        ->components([

            // Pilihan kendaraan
            Select::make('id_kendaraan')
                ->label('Kendaraan')
                ->relationship('kendaraan', 'plat_nomor')
                ->getOptionLabelFromRecordUsing(
                    fn (TbKendaraan $record): string =>
                        $record->plat_nomor . ' - ' . ucfirst($record->jenis_kendaraan)
                )
                ->searchable(['plat_nomor', 'jenis_kendaraan'])
                ->preload()
                ->live()
                ->afterStateUpdated(function ($state, Set $set) {

                    // Kosongkan tarif sebelumnya
                    $set('id_tarif', null);

                    if (blank($state)) {
                        return;
                    }

                    // Ambil data kendaraan
                    $kendaraan = TbKendaraan::find($state);

                    if (! $kendaraan) {
                        return;
                    }

                    // Cari tarif sesuai jenis kendaraan
                    $tarif = TbTarif::where(
                        'jenis_kendaraan',
                        $kendaraan->jenis_kendaraan
                    )->first();

                    // Isi tarif otomatis
                    $set('id_tarif', $tarif?->id_tarif);
                })
                ->required(),

            // Tarif otomatis berdasarkan kendaraan
            Select::make('id_tarif')
                ->label('Tarif')
                ->options(function (Get $get): array {

                    $kendaraan = TbKendaraan::find(
                        $get('id_kendaraan')
                    );

                    if (! $kendaraan) {
                        return [];
                    }

                    return TbTarif::where(
                        'jenis_kendaraan',
                        $kendaraan->jenis_kendaraan
                    )
                        ->get()
                        ->mapWithKeys(fn ($t) => [
                            $t->id_tarif =>
                                ucfirst($t->jenis_kendaraan) .
                                ' - Rp' .
                                number_format($t->tarif_per_jam, 0, ',', '.') .
                                '/jam',
                        ])
                        ->toArray();
                })
                ->required(),

            Select::make('id_area')
    ->label('Area Parkir')
    ->relationship(
        name: 'areaParkir',
        titleAttribute: 'nama_area',
        modifyQueryUsing: function (
            Builder $query,
            string $operation,
            ?TbTransaksi $record
        ): Builder {

            // Ambil area yang sedang digunakan saat edit
            $areaSaatIni = $operation === 'edit'
                ? $record?->areaParkir?->getKey()
                : null;

            return $query->where(function (Builder $query) use ($areaSaatIni) {

                // Hanya area yang belum penuh
                $query->whereColumn('terisi', '<', 'kapasitas');

                // Tetap tampilkan area lama saat mengedit transaksi
                if ($areaSaatIni !== null) {
                    $query->orWhereKey($areaSaatIni);
                }

            });
        }
    )
    ->searchable()
    ->preload()
    ->required()
    ->noOptionsMessage('Semua area parkir sudah penuh.'),

            DateTimePicker::make('waktu_masuk')
                ->default(now())
                ->required(),

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

                TextColumn::make('tarif.jenis_kendaraan')
                    ->label('Jenis Kendaraan'),

                TextColumn::make('areaParkir.nama_area')
                    ->label('Area Parkir'),

                TextColumn::make('waktu_masuk')
                    ->dateTime()
                    ->sortable(),

                TextColumn::make('waktu_keluar')
                    ->placeholder('-'),

                TextColumn::make('durasi_jam')
                    ->placeholder('-')
                    ->sortable(),

                TextColumn::make('durasi_jam')
                    ->placeholder('-'),

                TextColumn::make('status')
                    ->badge(),
                
                TextColumn::make('biaya_total')
                    ->money('idr', true)
                    ->placeholder('-'),
           ])
            ->recordActions([
                Action::make('cetak_struk')
    ->label('Cetak Struk')
    ->icon('heroicon-o-printer')
    ->color('primary')
    ->visible(fn (TbTransaksi $record) => $record->status === 'keluar')
    ->url(fn (TbTransaksi $record) => route(
        'petugas.struk',
        $record->id_transaksi
    ))
    ->openUrlInNewTab(),
    
                Action::make('keluar')
                ->label('Keluar')
                ->icon('heroicon-o-arrow-right-start-on-rectangle')
                ->color('success')
                ->requiresConfirmation()
                ->visible(fn (TbTransaksi $record) => $record->status === 'masuk')
                ->action(function (TbTransaksi $record) {

                    DB::transaction(function () use ($record) {

                        // Ambil transaksi dan kunci datanya
                        $transaksi = TbTransaksi::whereKey($record->getKey())
                            ->lockForUpdate()
                            ->firstOrFail();

            // Pastikan transaksi belum keluar
            if ($transaksi->status !== 'masuk') {
                return;
            }

            // Waktu keluar
            $keluar = now();

            // Hitung durasi parkir
            $masuk = Carbon::parse($transaksi->waktu_masuk);

            $jam = max(
                1,
                (int) ceil($masuk->diffInMinutes($keluar) / 60)
            );

            // Hitung biaya parkir
            $biaya = $jam * $transaksi->tarif->tarif_per_jam;

            // Update transaksi
            $transaksi->update([
                'waktu_keluar' => $keluar,
                'durasi_jam'   => $jam,
                'biaya_total'  => $biaya,
                'status'       => 'keluar',
            ]);

            // Kurangi jumlah kendaraan yang terisi
            $area = $transaksi->areaParkir()
                ->lockForUpdate()
                ->first();

            if ($area && $area->terisi > 0) {
                $area->decrement('terisi');
            }

        });

    }),

                EditAction::make()
                ->visible(fn (TbTransaksi $record) => $record->status === 'masuk'),
            
            ]);
            
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageTbTransaksis::route('/'),
        ];
    }
}
