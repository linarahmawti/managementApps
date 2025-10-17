<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'position',
        'salary',
        'hire_date',
        'status',
    ];

    protected $casts = [
        'hire_date' => 'date',
        'salary' => 'decimal:2',
    ];

    public function assignments()
    {
        return $this->hasMany(Assignment::class, 'karyawan_id');
    }

    public function progressReports()
    {
        return $this->hasMany(ProgressReport::class, 'karyawan_id');
    }
}
