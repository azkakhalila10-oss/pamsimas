<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelanggan extends Model
{
    use HasFactory;

    // Supaya aman dari error saat input data warga baru
    protected $guarded = []; 

    // Relasi ke Tagihan (1 Pelanggan punya banyak Tagihan)
    public function tagihan()
    {
        return $this->hasMany(Tagihan::class);
    }
}