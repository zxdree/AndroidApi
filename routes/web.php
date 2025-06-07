<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JaketWebController;

// Tampilkan form tambah jaket
Route::get('/jakets/create', [JaketWebController::class, 'create'])->name('jakets.create');
Route::post('/jakets', [JaketWebController::class, 'store'])->name('jakets.store.web');
Route::get('/jakets', [JaketWebController::class, 'index'])->name('jakets.index'); // Opsional: untuk melihat daftar jaket
Route::get('/getImage/{filename}', function ($filename) {
    $path = storage_path('app/public/jaket_images/' . $filename);
    // $a = asset('storage/jaket_images/' . $filename);
    if (!file_exists($path)) {
        abort(404);
    }

    // dd($path);
    return response()->file($path);
})->name('getImage');


