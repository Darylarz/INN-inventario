<?php

use App\Http\Controllers\Api\InventoryController;

// ...
Route::middleware('auth:sanctum')->group(function () {
    Route::get('inventory', [InventoryController::class, 'index']);
});