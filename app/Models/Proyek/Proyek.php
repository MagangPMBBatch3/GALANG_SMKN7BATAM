<?php

namespace App\Models\Proyek;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Proyek extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $table = 'proyek';

    protected $primaryKey = 'id';

    protected $fillable = [
        'kode',
        'nama',
        'tanggal',
        'nama_sekolah',
    ];

    protected $casts = [
        'deleted_at' => 'datetime',
        'updated_at' => 'datetime',
        'created_at' => 'datetime',
    ];
}
