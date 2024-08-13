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
        Schema::create('kendaraans', function (Blueprint $table) {
            $table->id();
            $table->string('nopol')->nullable();
            $table->string('jenis_kendaraan')->nullable();
            $table->string('panjang');
            $table->string('lebar');
            $table->string('tinggi');
            $table->string('berat_maksimal');
            $table->string('no_rangka');
            $table->string('tanggal_pajak_plat')->nullable();
            $table->string('tanggal_pajak_stnk')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kendaraans');
    }
};
