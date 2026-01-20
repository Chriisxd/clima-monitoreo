<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClimaController;
use App\Http\Controllers\ComentarioController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\RegisteredUserController;

Route::post('/logout', function () {
    Auth::logout();
    return redirect('/login');
})->name('logout');

Route::get('/', function () {
    return redirect()->route('clima.index');
});


Route::middleware('guest')->group(function () {
    Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('/register', [RegisteredUserController::class, 'store']);
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