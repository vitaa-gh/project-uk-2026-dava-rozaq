<?php

namespace App\Models;

use App\Models\TbKendaraan;
use App\Models\TbTarif;
use App\Models\TbAreaParkir;
use Illuminate\Database\Eloquent\Model;
use App\Models\TbLogAktivitas;
use Illuminate\Support\Facades\Auth;

class TbTransaksi extends Model
{
        protected $table = 'tb_transaksis';
        protected $primaryKey = 'id_transaksi';
        protected $fillable = [
            'id_parkir',
            'id_kendaraan',
            'waktu_masuk',
            'waktu_keluar',
            'id_tarif',
            'durasi_jam',
            'biaya_total',
            'status',
            'id_user',
            'id_area',
        ];

        public function kendaraan() {
            return $this->belongsTo(TbKendaraan::class, 'id_kendaraan');
        }

        public function tarif() {
            return $this->belongsTo(TbTarif::class, 'id_tarif');
        }

        public function areaParkir() {
            return $this->belongsTo(TbAreaParkir::class, 'id_area');
        }

        protected static function booted(): void
{
    // Otomatis mengatur status saat transaksi dibuat
    static::creating(function (TbTransaksi $transaksi) {
        $transaksi->status ??= 'masuk';
    });

    // Saat kendaraan masuk, jumlah terisi bertambah 1
    static::created(function (TbTransaksi $transaksi) {
        if ($transaksi->status === 'masuk') {
            TbAreaParkir::where('id_area', $transaksi->id_area)
                ->increment('terisi');
        }
    });

    // Saat kendaraan keluar, jumlah terisi berkurang 1
    static::updated(function (TbTransaksi $transaksi) {
        $statusLama = $transaksi->getOriginal('status');

        if ($statusLama === 'masuk' && $transaksi->status === 'keluar') {
            TbAreaParkir::where('id_area', $transaksi->id_area)
                ->where('terisi', '>', 0)
                ->decrement('terisi');
        }
    });
    
    // Ketika transaksi kendaraan masuk dibuat
    static::created(function ($transaksi) {

        $transaksi->loadMissing('kendaraan');

        TbLogAktivitas::create([
            'id_user' => Auth::id() ?? $transaksi->id_user,
            'aktivitas' => 'Menambahkan transaksi kendaraan masuk',
            'jenis_kendaraan' => $transaksi->kendaraan->jenis_kendaraan ?? 'lainnya',
            'waktu_aktivitas' => now(),
        ]);

    });

    // Ketika transaksi kendaraan keluar diselesaikan
    static::updated(function ($transaksi) {

        if ($transaksi->wasChanged('status') &&
            $transaksi->status === 'keluar') {

            $transaksi->loadMissing('kendaraan');

            TbLogAktivitas::create([
                'id_user' => Auth::id() ?? $transaksi->id_user,
                'aktivitas' => 'Menyelesaikan transaksi kendaraan keluar',
                'jenis_kendaraan' => $transaksi->kendaraan->jenis_kendaraan ?? 'lainnya',
                'waktu_aktivitas' => now(),
            ]);
        }

    });
}

protected function casts(): array
{
    return [
        'waktu_masuk' => 'datetime',
        'waktu_keluar' => 'datetime',
    ];
}
}

