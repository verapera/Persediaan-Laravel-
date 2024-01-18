<?php

namespace App\Models;
use App\Models\BarangMasuk;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Barang extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $fillable = [
        'image',
        'nama_barang',
        'harga',
        'stok',
        'deskripsi'
    ];
}
