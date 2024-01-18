<?php

namespace App\Models;
use App\Models\Barang;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarangKeluar extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    protected $table = 'barang_keluars';
     public function Barang()
     {
        return $this->belongsTo(Barang::class);
     }
}
