<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tagihan extends Model
{
    use HasFactory;

    // Ini kunci utamanya! Memberi tahu Laravel nama tabel yang benar (pakai 's')
    protected $table = 'tagihans'; 

    // Mengizinkan semua kolom untuk diisi data
    protected $guarded = []; 

    // Relasi ke Pelanggan (Setiap tagihan milik 1 pelanggan)
    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class);
    }
}