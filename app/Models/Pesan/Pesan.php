<?php

namespace App\Models\Pesan;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pesan extends Model
{
    use SoftDeletes;

    protected $table = 'pesan';

    public function pengirim()
    {
        return $this->belongsTo(\App\Models\UserProfile\UserProfile::class, 'pengirim_id');
    }

    public function penerima()
    {
        return $this->belongsTo(\App\Models\UserProfile\UserProfile::class, 'penerima_id');
    }

    public function jenis()
    {
        return $this->belongsTo(\App\Models\JenisPesan\JenisPesan::class, 'jenis_id');
    }
}