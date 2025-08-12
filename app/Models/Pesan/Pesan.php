<?php

namespace App\Models\Pesan;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pesan extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'pesan';

    protected $primaryKey = 'id';

    protected $fillable = [
        'pengirim',
        'penerima',
        'isi',
        'parent_id',
        'tgl_pesan',
        'jenis_id',
    ];

    protected $casts = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function jenis()
    {
        return $this->belongsTo('App\Models\JenisPesan\JenisPesan', 'jenis_id');
    }
}
