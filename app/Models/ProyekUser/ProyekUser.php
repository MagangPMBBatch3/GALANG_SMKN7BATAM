<?php

namespace App\Models\ProyekUser;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProyekUser extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $table = 'proyek_user';

    protected $primaryKey = 'id';

    protected $fillable = [
        'proyek_id',
        'user_profile_id',
    ];

    protected $casts = [
        'proyek_id' => 'integer',
        'user_profile_id' => 'integer',
    ];

    public function proyek()
    {
        return $this->belongsTo('App\Models\Proyek\Proyek', 'proyek_id');
    }

    public function userProfile()
    {
        return $this->belongsTo('App\Models\UserProfile\UserProfile', 'user_profile_id');
    }
}
