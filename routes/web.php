<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ClimaController;
use App\Http\Controllers\ComentarioController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Models\Comentario; 


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
    Route::patch('/clima/{clima}', [ClimaController::class, 'update'])->name('clima.update');
    Route::delete('/clima/{clima}', [ClimaController::class, 'destroy'])->name('clima.destroy');


    Route::post('/clima/{clima}/comentarios', [ComentarioController::class, 'store'])->name('comentarios.store');
    

    Route::patch('/comentarios/{comentario}', [ComentarioController::class, 'update'])
        ->name('comentarios.update')
        ->whereNumber('comentario'); 

    Route::delete('/comentarios/{comentario}', [ComentarioController::class, 'destroy'])
        ->name('comentarios.destroy')
        ->whereNumber('comentario'); 
});

require __DIR__.'/auth.php';