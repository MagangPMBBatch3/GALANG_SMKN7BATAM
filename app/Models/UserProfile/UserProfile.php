<?php

namespace App\Models\UserProfile;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserProfile extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $table = 'user_profile';

    protected $fillable = [
        'user_id',
        'nama_lengkap',
        'nrp',
        'alamat',
        'foto',
        'level_id',
        'status_id',
        'bagian_id',
    ];

    protected $casts = [

        'deleted_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(\App\Models\User\User::class);
    }

    public function level()
    {
        return $this->belongsTo(\App\Models\Level\Levels::class);
    }

    public function status()
    {
        return $this->belongsTo(\App\Models\Status\Statuses::class);
    }

    public function bagian()
    {
        return $this->belongsTo(\App\Models\Bagian\Bagians::class);
    }
}
