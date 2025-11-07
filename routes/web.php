
<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\inventarioController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ArticleController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth:sanctum')->group(function () {
    Route::get('articles', [ArticleController::class, 'index']);
    // Aquí irán las rutas para crear, actualizar y eliminar...
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/i/indice', [inventarioController::class, 'index'])->name('inventario-index');


    Route::get('/i/nueva-entrada', [inventarioController::class, 'create'])->name('inventario-create');
    Route::get('/i/nueva-entrada/store', [inventarioController::class, 'store'])->name('inventario-store');
    Route::get('/i/editar-entrada', [inventarioController::class, 'edit'])->name('inventario-edit');
    Route::get('/i/editar-entrada/update', [inventarioController::class, 'update'])->name('inventario-update');
    Route::get('/i/mostrar-entrada/${id}', [inventarioController::class, 'show'])->name('inventario-show');
    Route::get('/i/eliminar-entrada/${id}', [inventarioController::class, 'delete'])->name('inventario-delete');
}); # ${id} se puede modificar

require __DIR__.'/auth.php';
