<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClimaController;
use App\Http\Controllers\ComentarioController;

Route::get('/', function () {
    return redirect()->route('clima.index');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/clima', [ClimaController::class, 'index'])->name('clima.index');
    Route::post('/buscar-clima', [ClimaController::class, 'buscar'])->name('clima.buscar');

    Route::post('/clima/{clima}/comentarios', [ComentarioController::class, 'store'])
        ->name('comentarios.store');

 
    Route::delete('/clima/{clima}', [ClimaController::class, 'destroy'])->name('clima.destroy');
    Route::patch('/clima/{clima}', [ClimaController::class, 'update'])->name('clima.update');
});

require __DIR__.'/auth.php';