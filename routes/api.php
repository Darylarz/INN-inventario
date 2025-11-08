<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\InventoryController;

// Temporarily remove auth to test - you can add it back later
Route::get('/inventory', [InventoryController::class, 'index']);

// Alternative: Use web middleware for session-based auth
// Route::middleware('web')->group(function () {
//     Route::get('/inventory', [InventoryController::class, 'index']);
// });