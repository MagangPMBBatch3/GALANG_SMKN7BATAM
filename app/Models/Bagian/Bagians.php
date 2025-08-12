<?php

namespace App\Models\Bagian;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bagians extends Model
{
    use HasFactory;

    protected $table = 'bagian';

    protected $primaryKey = 'id';

    protected $fillable = [
        'nama',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public $timestamps = true;
}
