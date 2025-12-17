<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    HomeController,
    ProductoController,
    UbicacionController,
    InventarioController,
    CategoriaController,
    ReporteController,
    UserController,
    CuentaController
};

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Inicio
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/productos', [ProductoController::class, 'index'])->name('productos.index');

// Ubicaciones (solo admin)
Route::get('/ubicaciones', [UbicacionController::class, 'index'])
    ->middleware('can:usuario crear')
    ->name('ubicaciones.index');

// Inventario esto esta bien fino
Route::controller(InventarioController::class)->prefix('inventario')->group(function () {
    Route::get('/', 'index')->name('inventario.index');          // consultar artículo
    Route::get('/create', 'create')->name('inventario.create');  // añadir artículo
    Route::get('/edit/{id}', 'edit')->middleware('can:usuario crear')->name('inventario.edit'); // modificar artículo
    Route::get('/disabled', 'disabled')->middleware('can:usuario crear')->name('inventario.disabled'); // desincorporar artículo
});

// Categorías
Route::controller(CategoriaController::class)->prefix('categorias')->group(function () {
    Route::get('/', 'index')->name('categorias.index');
    Route::get('/pc', 'pc')->name('categorias.pc');
    Route::get('/consumibles', 'consumibles')->name('categorias.consumibles');
    Route::get('/herramientas', 'herramientas')->name('categorias.herramientas');
});

// Reportes (almacenista y admin)
Route::controller(ReporteController::class)->prefix('reportes')->middleware('can:articulo agregar')->group(function () {
    Route::get('/', 'index')->name('reportes.index');
    Route::get('/activos', 'activos')->name('reportes.activos');
    Route::get('/desincorporados', 'desincorporados')->name('reportes.desincorporados');
});

// Usuarios (solo admin)
Route::get('/admin/users', [UserController::class, 'index'])
    ->middleware('can:usuario crear')
    ->name('admin.users');

// Cuenta
Route::controller(CuentaController::class)->prefix('cuenta')->group(function () {
    Route::get('/select', 'select')->name('cuenta.select');
    Route::get('/perfil', 'perfil')->name('cuenta.perfil');
    Route::get('/config', 'config')->name('cuenta.config');
});

// Logout
Route::post('/logout', [CuentaController::class, 'logout'])->name('logout');