<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tb_transaksis', function (Blueprint $table) {
            $table->id('id_transaksi');
            $table->foreignId('id_parkir', 11)->default(1);
            $table->foreignId('id_kendaraan', 15)->default(1);
            $table->datetime('waktu_masuk');
            $table->datetime('waktu_keluar')->nullable();
            $table->foreignId('id_tarif', 11)->default(1);
            $table->string('durasi_jam', 15)->nullable();
            $table->decimal('biaya_total', 10,0)->nullable();
            $table->enum('status', ['masuk','keluar','-']);
            $table->foreignId('id_user', 11)->default(1);
            $table->foreignId('id_area', 11)->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_transaksis');
    }
};
