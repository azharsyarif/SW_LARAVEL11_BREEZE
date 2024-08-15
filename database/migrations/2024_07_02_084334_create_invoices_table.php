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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('no_po_customer')->constrained('p_o_customers')->onDelete('cascade');
            $table->string('no_inv')->unique();
            $table->date('tanggal_kirim_inv');
            $table->decimal('biaya_operasional', 15, 2);
            $table->decimal('revenue', 15, 2);
            $table->decimal('net_income', 15, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
