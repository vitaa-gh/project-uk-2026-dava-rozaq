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
        Schema::create('tb_area_parkirs', function (Blueprint $table) {
            $table->id('id_area', 11);
            $table->string('nama_area', 50);
            $table->string('kapasitas', 5);
            $table->string('terisi', 5);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tb_area_parkirs', function (Blueprint $table) {
        $table->dropColumn('terisi');
    });
        Schema::dropIfExists('tb_area_parkirs');
    }
};
