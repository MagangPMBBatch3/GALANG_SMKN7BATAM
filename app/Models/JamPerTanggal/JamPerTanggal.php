<?php

namespace App\Models\JamPerTanggal;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JamPerTanggal extends Model
{
    
    use HasFactory;

    use SoftDeletes;

    protected $table = 'jam_per_tanggal';

    protected $primaryKey = 'id';
    protected $fillable = [
        'user_profile_id',
        'proyek_id',
        'tanggal',
        'jam',
    ];

    protected $casts = [
        'user_profile_id' => 'integer',
        'proyek_id' => 'integer',
        'tanggal' => 'date',
        'jam' => 'decimal:2',
    ];

    public function userProfile()
    {
        return $this->belongsTo('App\Models\UserProfile\UserProfile', 'user_profile_id');
    }
    public function proyek()
    {
        return $this->belongsTo('App\Models\Proyek\Proyek', 'proyek_id');
    }
}
