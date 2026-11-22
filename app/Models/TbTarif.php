<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TbTarif extends Model
{
    protected $table = 'tb_tarifs';
    protected $primaryKey = 'id_tarif';
    protected $fillable = [
        'id_tarif',
        'jenis_kendaraan',
        'tarif_per_jam'
    ];

    public function transaksi() {
        return $this->hasMany(Transaksi::class, 'tarif_id');
    }
}
