<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jaket extends Model
{
    use HasFactory;

    /**
     * Nama tabel yang terkait dengan model.
     * @var string
     */
    protected $table = 'jakets'; // Sesuaikan jika nama tabel Anda berbeda, misal 'jaket' (singular)

    /**
     * Atribut yang dapat diisi secara massal (mass assignable).
     * @var array<int, string>
     */
    protected $fillable = [
        // "id",
        'nama',
        'jenis',
        'status',
        'gambar',
        'Authorization',
        // 'mine',
    ];

    /**
     * Casting atribut ke tipe data tertentu.
     * @var array<string, string>
     */
    protected $casts = [
        'mine' => 'boolean', // 'mine' ditangani sebagai boolean (true/false, yang disimpan sebagai 1/0)
    ];
}
