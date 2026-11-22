<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class TbLogAktivitas extends Model
{
    protected $table = 'tb_log_aktivitas';

    protected $primaryKey = 'id_log';

    protected $fillable = [
        'id_user',
        'aktivitas',
        'jenis_kendaraan',
        'waktu_aktivitas',
    ];

    protected $casts = [
        'waktu_aktivitas' => 'datetime',
    ];

    

public function user(): BelongsTo
{
    return $this->belongsTo(
        \App\Models\User::class,
        'id_user',
        'id'
    );
}
}
