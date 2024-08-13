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
        Schema::create('rekanans', function (Blueprint $table) {
            $table->id();
            $table->string('nama_pt');
            $table->string('npwp');
            $table->string('no_tlp');
            $table->string('jenis_usaha');
            $table->string('alamat');
            $table->string('term_agrement');
            $table->string('upload_npwp');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rekanans');
    }
};
