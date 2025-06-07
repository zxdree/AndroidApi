<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jaket extends Model
{
    use HasFactory;

   
    protected $table = 'jakets';


    protected $fillable = [
        // "id",
        'nama',
        'jenis',
        'status',
        'gambar',
        'Authorization',
        // 'mine',
    ];


    protected $casts = [
        'mine' => 'boolean',
    ];
}
