<?php

namespace App\Models\JamKerja;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JamKerja extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $table = 'jam_kerja';

    protected $primaryKey = 'id';

    protected $fillable = [
        'user_profile_id',
        'no_wbs',
        'kode_proyek',
        'proyek_id',
        'Aktivitas_id',
        'status_id',
        'tanggal',
        'jumlah_jam',
        'jam',
    ];

    protected $casts = [
        'updated_at' => 'datetime',
        'created_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    public function userProfile()
    {
        return $this->belongsTo('App\Models\UserProfile\UserProfile', 'user_profile_id');
    }

    public function proyek()
    {
        return $this->belongsTo('App\Models\Proyek\Proyek', 'proyek_id');
    }

    public function aktivitas()
    {
        return $this->belongsTo('App\Models\Aktivitas\Aktivitas', 'Aktivitas_id');
    }

    public function status()
    {
        return $this->belongsTo('App\Models\StatusJamKerja\StatusJamKerja', 'status_id');
    }

    public function mode()
    {
        return $this->belongsTo('App\Models\ModeJamKerja\ModeJamKerja', 'mode_id');
    }
}
