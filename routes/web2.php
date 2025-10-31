
<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\InventarioController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
/*
// 🌐 Página principal (Welcome)
Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

// 📊 Dashboard (solo usuarios autenticados y verificados)
Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// 👤 Rutas protegidas por autenticación
Route::middleware('auth')->group(function () {
    // 👥 Rutas del perfil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // 📦 Rutas del módulo de inventario
    Route::prefix('i')->group(function () {
        Route::get('/indice', [InventarioController::class, 'index'])->name('inventario.index');     // Ver lista
        Route::get('/nueva-entrada', [InventarioController::class, 'create'])->name('inventario.create'); // Formulario crear
        Route::post('/nueva-entrada', [InventarioController::class, 'store'])->name('inventario.store'); // Guardar nuevo
        Route::get('/editar-entrada/{id}', [InventarioController::class, 'edit'])->name('inventario.edit'); // Formulario editar
        Route::put('/editar-entrada/{id}', [InventarioController::class, 'update'])->name('inventario.update'); // Actualizar
        Route::get('/mostrar-entrada/{id}', [InventarioController::class, 'show'])->name('inventario.show'); // Mostrar detalle
        Route::delete('/eliminar-entrada/{id}', [InventarioController::class, 'destroy'])->name('inventario.destroy'); // Eliminar
    });
});

// 🔐 Rutas de autenticación (login, registro, etc.)
require __DIR__.'/auth.php'; 