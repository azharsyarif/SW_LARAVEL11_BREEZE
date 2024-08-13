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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('no_order')->unique();
            $table->foreignId('no_po')->constrained('p_o_customers')->onDelete('cascade');
            $table->string('asal');
            $table->string('tujuan');
            $table->string('layanan');
            $table->string('total_km'); 
            $table->string('total_koli');
            $table->string('total_berat');
            $table->text('deskripsi_barang');
            $table->foreignId('rekanan_id')->constrained('rekanans')->onDelete('cascade'); // FK to rekanans
            $table->foreignId('kendaraan_id')->nullable()->constrained('kendaraans')->onDelete('cascade');
            $table->string('harga_deal');
            $table->string('total_harga_deal');
            $table->string('upload_harga_deal');
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
