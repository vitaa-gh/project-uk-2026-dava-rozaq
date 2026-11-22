<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\TbTransaksi;

class StrukParkirController extends Controller
{
    public function cetak($id)
    {
        $transaksi = TbTransaksi::with([
            'kendaraan',
            'tarif',
            'areaParkir',
        ])->findOrFail($id);

        if ($transaksi->status !== 'keluar') {
            abort(403, 'Transaksi belum selesai.');
        }

        return view('petugas.struk', compact('transaksi'));
    }
}
