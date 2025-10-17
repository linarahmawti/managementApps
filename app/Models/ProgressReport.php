<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProgressReport extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'assignment_id',
        'karyawan_id',
        'nama_barang',
        'lokasi_pengantaran',
        'jumlah_diantar',
        'harga_total',
        'status_pengantaran',
        'catatan',
        'tanggal_laporan'
    ];

    protected $casts = [
        'tanggal_laporan' => 'datetime',
        'harga_total' => 'decimal:2'
    ];

    // Relationships
    public function assignment()
    {
        return $this->belongsTo(Assignment::class);
    }

    public function karyawan()
    {
        return $this->belongsTo(User::class, 'karyawan_id');
    }
}
