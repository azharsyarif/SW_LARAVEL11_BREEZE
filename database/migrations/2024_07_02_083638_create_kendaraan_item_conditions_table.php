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
        Schema::create('kendaraan_item_conditions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('service_kendaraan_id')->constrained('service_kendaraans')->onDelete('cascade');
            $table->string('item_name');
            $table->string('item_value');
            $table->string('desc')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kendaraan_item_conditions');
    }
};
