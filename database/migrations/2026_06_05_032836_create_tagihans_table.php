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
        Schema::create('tagihans', function (Blueprint $table) {
            $table->id();
            // Menyambungkan tagihan dengan pelanggan
            $table->foreignId('pelanggan_id')->constrained('pelanggans')->onDelete('cascade');
            
            $table->string('bulan');
            $table->string('tahun');
            $table->integer('meteran_lalu')->default(0);
            $table->integer('meteran_baru');
            $table->integer('total_kubik');
            $table->integer('total_tagihan');
            $table->string('status')->default('belum_bayar');
            $table->string('jenis_pembayaran')->nullable(); // Kolom ini yang biasanya bikin error!
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tagihans');
    }
};
