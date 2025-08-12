<?php

namespace App\Models\Lembur;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lembur extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $table = 'lembur';

    protected $primaryKey = 'id';

    protected $fillable = [
        'user_profile_id',
        'proyek_id',
        'tanggal',
    ];

    protected $casts = [
        'deleted_at' => 'datetime',
        'updated_at' => 'datetime',
        'created_at' => 'datetime',
    ];

    public function userProfile()
    {
        return $this->belongsTo(\App\Models\UserProfile\UserProfile::class, 'user_profile_id');
    }

    public function proyek()
    {
        return $this->belongsTo(\App\Models\Proyek\Proyek::class, 'proyek_id');
    }
}
