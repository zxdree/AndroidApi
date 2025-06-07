
<?php
use App\Http\Controllers\Api\JaketController;
use Illuminate\Support\Facades\Route;

Route::prefix('jakets')->group(function () {
    Route::get('/', [JaketController::class, 'index']); // Tidak perlu parameter uid lagi
    Route::get('/all', [JaketController::class, 'all']);
    Route::post('/', [JaketController::class, 'store']);
    Route::get('/{id}', [JaketController::class, 'show']);
    Route::post('/{id}', [JaketController::class, 'update']);
    Route::delete('/{id}', [JaketController::class, 'destroy']);
});

