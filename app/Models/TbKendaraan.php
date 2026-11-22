<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TbKendaraan extends Model
{
    protected $table = 'tb_kendaraans';
    protected $primaryKey = 'id_kendaraan';
    protected $fillable = [
        'id_kendaraan',
        'plat_nomor',
        'jenis_kendaraan',
        'warna',
        'pemilik',
        'id_user',
    ];

    public function transaksi() {
        return $this->hasMany(Transaksi::class, 'kendaraan_id');
    }
}
