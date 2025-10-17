<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Barang extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'nama_barang',
        'kode_barang',
        'harga_barang',
        'stok_barang',
        'deskripsi',
    ];

    protected $casts = [
        'harga_barang' => 'decimal:2'
    ];

    // Relationships
    public function assignments()
    {
        return $this->hasMany(Assignment::class);
    }
}
