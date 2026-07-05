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
        // Pastikan nama tabelnya 'pembayarans'
        Schema::create('pembayarans', function (Blueprint $table) {
            $table->id();
            
            // Perhatikan bagian 'tagihans' di bawah ini (wajib pakai 's')
            $table->foreignId('tagihan_id')->constrained('tagihans')->onDelete('cascade');
            
            $table->date('tgl_bayar');
            $table->string('bukti_transfer')->nullable();
            $table->string('jenis_pembayaran')->default('transfer');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembayarans');
    }
};