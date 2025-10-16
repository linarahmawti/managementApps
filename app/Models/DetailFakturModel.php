<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DetailFakturModel extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $table = 'detail';

    public function faktur(){
        return $this->belongsTo(FakturModel::class, 'id');
    }
    public function barang(){
        return $this->belongsTo(Barang::class);
    }
}
