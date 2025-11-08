
<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\inventarioController;
use App\Http\Controllers\AdminController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\InventoryController;
use App\Http\Controllers\InventoryManagementController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [InventoryManagementController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

// Temporary debug route - remove after testing
Route::get('/debug-inventory', function() {
    $count = \App\Models\Inventory::count();
    $sample = \App\Models\Inventory::take(5)->get();
    return response()->json([
        'total_count' => $count,
        'sample_data' => $sample,
        'table_name' => (new \App\Models\Inventory)->getTable()
    ]);
})->middleware('auth');

// Test API route in web.php instead
Route::get('/api/inventory-test', [\App\Http\Controllers\Api\InventoryController::class, 'index']);

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
    
    // Password update route
    Route::put('/password', [ProfileController::class, 'updatePassword'])->name('password.update');

    Route::get('/i/indice', [inventarioController::class, 'index'])->name('inventario-index');

});

// Admin Routes
Route::middleware(['auth', 'permission:admin panel'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');
    
    // User Management
    Route::get('/users', [AdminController::class, 'users'])->name('users');
    Route::get('/users/create', [AdminController::class, 'createUser'])->name('users.create');
    Route::post('/users', [AdminController::class, 'storeUser'])->name('users.store');
    Route::get('/users/{user}/edit', [AdminController::class, 'editUser'])->name('users.edit');
    Route::put('/users/{user}', [AdminController::class, 'updateUser'])->name('users.update');
    Route::delete('/users/{user}', [AdminController::class, 'destroyUser'])->name('users.destroy');
    
    // Inventory Management (Admin view)
    Route::get('/inventory', [AdminController::class, 'inventory'])->name('inventory');
}); # ${id} se puede modificar

require __DIR__.'/auth.php';
