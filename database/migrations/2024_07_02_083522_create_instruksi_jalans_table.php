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

        Schema::create('instruksi_jalans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders')->onDelete('cascade');
            $table->string('no_surat_jalan')->unique();
            $table->foreignId('driver_id')->constrained('users')->onDelete('cascade'); // Mengambil driver dari tabel users
            $table->foreignId('kenek_id')->nullable()->constrained('users')->onDelete('cascade'); // Mengambil kenek dari tabel users
            $table->string('nopol');
            $table->date('tanggal_jalan');
            $table->date('tanggal_stuffing')->nullable();
            $table->date('tanggal_stripping')->nullable();
            $table->string('estimasi_waktu_ke_tujuan');
            $table->string('estimasi_jarak');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('instruksi_jalans');
    }
};
