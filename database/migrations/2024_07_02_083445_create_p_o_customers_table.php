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
        Schema::create('p_o_customers', function (Blueprint $table) {
            $table->id();
            $table->string('no_po')->unique();
            $table->foreignId('rekanan_id')->constrained('rekanans')->onDelete('cascade');
            $table->string('alamat');
            $table->foreignId('pic_customer_id')->constrained('p_i_c_customers')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('p_o_customers');
    }
};
