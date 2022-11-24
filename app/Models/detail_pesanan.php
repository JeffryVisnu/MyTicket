<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\pesanan;

class detail_pesanan extends Model
{
    protected $fillable = [
        'id_pesanan','jumlah_tiket','harga','total_harga','kode_pemesanan'
    ];

    public function pesanan()
    {
        return $this->belongsTo(pesanan::class, 'id_pesanan','id');
    }
}
