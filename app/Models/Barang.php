<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;
    protected $table = 'barangs';
    protected $fillable = ['nama_barang', 'stok', 'jenis_barang'];
    
 
    public function transaksis()
    {
        return $this->hasMany(Transaksi::class, 'barang_id');
    }
}
