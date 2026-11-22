<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TbAreaParkir extends Model
{
    protected $table = 'tb_area_parkirs';
    protected $primaryKey = 'id_area';
    protected $fillable = [
        'id_area',
        'nama_area',
        'kapasitas',
        'terisi',           
    ];

    public function transaksi(){
        return $this->hasMany(Transaksi::class, 'area_parkir_id');
    }
}
