<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\InventoryController;
use App\Http\Controllers\inventarioController as WebInventarioController;
use App\Http\Controllers\Api\LoadtestInventarioController;
use App\Models\Inventario;

// Temporarily remove auth to test - you can add it back later
// Expose the existing web controller index for API listing (reusing web logic)
Route::get('/inventario', [WebInventarioController::class, 'index']);

// Ruta temporal para pruebas de carga sin CSRF. Protegida por X-API-KEY = env('LOADTEST_API_KEY')
Route::post('/loadtest/inventario', [LoadtestInventarioController::class, 'store']);

// Alternative: Use web middleware for session-based auth
// Route::middleware('web')->group(function () {
//     Route::get('/inventory', [InventoryController::class, 'index']);
// });