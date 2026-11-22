<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Petugas\StrukParkirController;

Route::get('/', function () {
    return view('welcome');
});



Route::get('/petugas/struk/{id}', [StrukParkirController::class, 'cetak'])
    ->name('petugas.struk');
