<?php

namespace App\Models\Aktivitas;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Aktivitas extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'aktivitas';
    protected $primaryKey = 'id';
    protected $fillable = [
        'bagian_id',
        'user_profile_id',
        'proyek_id',
        'keterangan_id',
        'no_wbs',
        'nama',
        'description',
        'status',
        'progress',
        'start_date',
        'end_date',
        'priority',
    ];

    protected $casts = [
        'deleted_at' => 'datetime',
        'updated_at' => 'datetime',
        'created_at' => 'datetime',
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function bagian()
    {
        return $this->belongsTo(\App\Models\Bagian\Bagians::class);
    }

    public function userProfile()
    {
        return $this->belongsTo(\App\Models\UserProfile\UserProfile::class);
    }

    public function proyek()
    {
        return $this->belongsTo(\App\Models\Proyek\Proyek::class);
    }

    public function keterangan()
    {
        return $this->belongsTo(\App\Models\Keterangan\Keterangan::class);
    }

    /**
     * Scope untuk filtering aktivitas berdasarkan user
     */
    public function scopeByUser($query, $userProfileId)
    {
        return $query->where('user_profile_id', $userProfileId);
    }

    /**
     * Scope untuk filtering aktivitas berdasarkan proyek
     */
    public function scopeByProyek($query, $proyekId)
    {
        return $query->where('proyek_id', $proyekId);
    }

    /**
     * Scope untuk filtering aktivitas berdasarkan status
     */
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Accessor untuk progress percentage
     */
    public function getProgressPercentageAttribute()
    {
        return $this->progress . '%';
    }

    /**
     * Check if activity is overdue
     */
    public function getIsOverdueAttribute()
    {
        return $this->end_date && $this->end_date < now() && $this->status !== 'completed';
    }
}
