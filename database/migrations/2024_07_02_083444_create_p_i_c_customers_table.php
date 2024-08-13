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
        Schema::create('p_i_c_customers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('nama_pt')->constrained('rekanans')->onDelete('cascade');
            $table->string('nama');
            $table->string('no_tlp');
            $table->string('posisi');
            $table->string('cabang');
            $table->timestamps();
        });
    }

/**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('p_i_c_customers');
    }
};
