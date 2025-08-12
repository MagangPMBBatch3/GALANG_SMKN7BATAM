<?php

namespace App\Models\Aktivitas;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Aktivitas extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $table = 'aktivitas';

    protected $primaryKey = 'id';

    protected $fillable = [
        'bagian_id',
        'no_wbs',
        'nama',
    ];

    protected $casts = [
        'deleted_at' => 'datetime',
        'updated_at' => 'datetime',
        'created_at' => 'datetime',
    ];

    public function bagian()
    {
        return $this->belongsTo(\App\Models\Bagian\Bagians::class);
    }
}
