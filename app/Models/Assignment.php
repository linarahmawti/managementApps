<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Assignment extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'barang_id',
        'karyawan_id',
        'jumlah',
        'harga_satuan',
        'subtotal',
        'lokasi_tujuan',
        'status',
        'tanggal_assignment',
        'catatan'
    ];

    protected $casts = [
        'tanggal_assignment' => 'date',
        'harga_satuan' => 'decimal:2',
        'subtotal' => 'decimal:2'
    ];

    // Relationships
    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }

    public function karyawan()
    {
        return $this->belongsTo(User::class, 'karyawan_id');
    }

    public function progressReports()
    {
        return $this->hasMany(ProgressReport::class);
    }
}
