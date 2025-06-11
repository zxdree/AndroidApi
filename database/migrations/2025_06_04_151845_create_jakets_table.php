<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('jakets', function (Blueprint $table) {
            $table->id(); // Menggunakan string sebagai primary key
            $table->string('nama');
            $table->string('jenis');
            $table->string('status');
            $table->string('gambar')->nullable(); // Kolom untuk menyimpan nama file gambar
            $table->string('Authorization')->nullable();
            $table->boolean('mine')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jakets');
    }
};
