<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClimaController;

Route::get('/', function () {
    return redirect()->route('clima.index');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/clima', [ClimaController::class, 'index'])->name('clima.index');
    Route::post('/buscar-clima', [ClimaController::class, 'buscar'])->name('clima.buscar');
});

require __DIR__.'/auth.php';