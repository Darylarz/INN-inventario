
<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\inventarioController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\InventoryController;
use App\Http\Controllers\InventoryManagementController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/inventory/create', [InventoryManagementController::class, 'create'])->name('inventory.create');
    Route::post('/inventory', [InventoryManagementController::class, 'store'])->name('inventory.store');
    Route::get('/inventory/{inventory}/edit', [InventoryManagementController::class, 'edit'])->name('inventory.edit');
    Route::put('/inventory/{inventory}', [InventoryManagementController::class, 'update'])->name('inventory.update');
    Route::delete('/inventory/{inventory}', [InventoryManagementController::class, 'destroy'])->name('inventory.destroy');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/i/indice', [inventarioController::class, 'index'])->name('inventario-index');

}); # ${id} se puede modificar

require __DIR__.'/auth.php';
