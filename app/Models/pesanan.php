<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\kategori;
use App\Models\tiket;

class pesanan extends Model
{
    protected $fillable = [
        'id_user','id_kategori','tanggal_pemesanan','metode_pembayaran'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user','id');
    }

    public function kategori()
    {
        return $this->belongsTo(kategori::class, 'id_kategori','id');
    }
}