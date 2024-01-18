<?php

namespace App\Models;
use App\Models\Barang;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BarangMasuk extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    protected $table = 'barang_masuks';
     public function Barang()
     {
        return $this->belongsTo(Barang::class);
     }
}
