<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\InventoryManagementController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Validation\ValidationException;

use App\Http\Controllers\ArticuloHardwareController;
use App\Http\Controllers\HerramientaController;
use App\Http\Controllers\ConsumibleController;
use App\Http\Controllers\ReportsController;


// raíz -> redirigir al dashboard (Blade)
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\InventoryMovementController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\LocationController;


// LOGIN (POST existente ajustado para redirigir si no es AJAX)
Route::post('/login', function (Request $request) {
    $credentials = $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required'],
    ]);

    if (!Auth::attempt($credentials)) {
        throw ValidationException::withMessages([
            'email' => ['Credenciales inválidas.'],
        ]);
    }

    $request->session()->regenerate();

    if ($request->wantsJson()) {
        return response()->json(['message' => 'ok']);
    }
    // Redirigir al índice de inventario después de login
    return redirect()->route('inventory.index');
});

// REGISTER (POST existente ajustado)
Route::post('/register', function (Request $request) {
    $data = $request->validate([
        'name' => ['required', 'string'],
        'email' => ['required', 'email', 'unique:users,email'],
        'password' => ['required', 'confirmed', 'min:6'],
    ]);

    $user = User::create([
        'name' => $data['name'],
        'email' => $data['email'],
        'password' => Hash::make($data['password']),
    ]);

    Auth::login($user);

    if ($request->wantsJson()) {
        return response()->json(['message' => 'ok'], 201);
    }
    // Temporal: redirigir al dashboard después de "register"
    return redirect()->route('dashboard');
});
// LOGOUT ajustado para redirigir en peticiones normales
Route::post('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    if ($request->wantsJson()) {
        return response()->json(['message' => 'ok']);
    }
    return redirect()->route('login');
});


/*
|--------------------------------------------------------------------------
| RUTAS PROTEGIDAS
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    // ahora la ruta /dashboard devuelve la vista Blade que monta Livewire
    
Route::get('/dashboard', [InventoryController::class, 'index'])->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::prefix('inventory')->name('inventory.')->group(function () {
        Route::get('/', [InventoryController::class, 'index'])->name('index');
        Route::get('/disabled', [InventoryController::class, 'disabledIndex'])->name('disabled');
        Route::post('/{inventory}/disable', [InventoryController::class, 'disable'])->name('disable');
        Route::post('/{inventory}/enable', [InventoryController::class, 'enable'])->name('enable');

        Route::get('/create', [InventoryController::class, 'create'])->name('create');
        Route::post('/store', [InventoryController::class, 'store'])->name('store');
        Route::get('/{inventory}/edit', [InventoryController::class, 'edit'])->name('edit');
        Route::put('/{inventory}', [InventoryController::class, 'update'])->name('update');
        Route::delete('/{inventory}', [InventoryController::class, 'destroy'])->name('destroy');
        Route::get('/{inventory}', [InventoryController::class, 'show'])->name('show');
    });

    // Reports
    Route::get('/reports', [ReportsController::class, 'index'])->name('reports.index');
    Route::post('/reports/pdf', [ReportsController::class, 'pdf'])->name('reports.pdf');


    Route::get('/{inventory}/entrada', [InventoryMovementController::class, 'createIn'])->name('inventory.entrada.create');
        Route::post('/{inventory}/entrada', [InventoryMovementController::class, 'storeIn'])->name('inventory.entrada.store');
        Route::get('/{inventory}/salida', [InventoryMovementController::class, 'createOut'])->name('inventory.salida.create');
        Route::post('/{inventory}/salida', [InventoryMovementController::class, 'storeOut'])->name('inventory.salida.store');
    // Admin
    
        Route::get('/users', [AdminController::class, 'users'])->name('admin.users');
    Route::get('/users/create', [AdminController::class, 'createUser'])->name('admin.users.create');
    Route::post('/users', [AdminController::class, 'storeUser'])->name('admin.users.store');
    Route::get('/users/{user}/edit', [AdminController::class, 'editUser'])->name('admin.users.edit');
    Route::put('/users/{user}', [AdminController::class, 'updateUser'])->name('admin.users.update');
    Route::delete('/users/{user}', [AdminController::class, 'destroyUser'])->name('admin.users.destroy');

// Ubicaciones
    Route::prefix('locations')->name('locations.')->middleware('can:usuario crear')->group(function () {
        Route::get('/', [LocationController::class, 'index'])->name('index');
        Route::get('/create', [LocationController::class, 'create'])->name('create');
        Route::post('/', [LocationController::class, 'store'])->name('store');
        Route::get('/{location}/edit', [LocationController::class, 'edit'])->name('edit');
        Route::put('/{location}', [LocationController::class, 'update'])->name('update');
        Route::delete('/{location}', [LocationController::class, 'destroy'])->name('destroy');
    });


     // Categorías (Tipos de inventario)
    Route::prefix('categories')->name('categories.')->middleware('can:usuario crear')->group(function () {
        Route::get('/', [CategoryController::class, 'index'])->name('index');
        Route::get('/create', [CategoryController::class, 'create'])->name('create');
        Route::post('/', [CategoryController::class, 'store'])->name('store');
        Route::get('/{category}/edit', [CategoryController::class, 'edit'])->name('edit');
        Route::put('/{category}', [CategoryController::class, 'update'])->name('update');
        Route::delete('/{category}', [CategoryController::class, 'destroy'])->name('destroy');
    });
    });

Route::middleware(['auth'])->group(function () {

    // =============================
    // RUTAS PARA ARTÍCULOS HARDWARE
    // =============================
    Route::get('/hardware', [ArticuloHardwareController::class, 'index'])->name('hardware.index');
    Route::get('/hardware/crear', [ArticuloHardwareController::class, 'crear'])->name('hardware.crear');
    Route::post('/hardware', [ArticuloHardwareController::class, 'guardar'])->name('hardware.guardar');
    Route::get('/hardware/{id}/editar', [ArticuloHardwareController::class, 'editar'])->name('hardware.editar');
    Route::put('/hardware/{id}', [ArticuloHardwareController::class, 'actualizar'])->name('hardware.actualizar');
    Route::delete('/hardware/{id}', [ArticuloHardwareController::class, 'eliminar'])->name('hardware.eliminar');


    // =====================
    // RUTAS PARA HERRAMIENTAS
    // =====================
    Route::get('/herramientas', [HerramientaController::class, 'index'])->name('herramientas.index');
    Route::get('/herramientas/crear', [HerramientaController::class, 'crear'])->name('herramientas.crear');
    Route::post('/herramientas', [HerramientaController::class, 'guardar'])->name('herramientas.guardar');
    Route::get('/herramientas/{id}/editar', [HerramientaController::class, 'editar'])->name('herramientas.editar');
    Route::put('/herramientas/{id}', [HerramientaController::class, 'actualizar'])->name('herramientas.actualizar');
    Route::delete('/herramientas/{id}', [HerramientaController::class, 'eliminar'])->name('herramientas.eliminar');


    // =====================
    // RUTAS PARA CONSUMIBLES
    // =====================
    Route::get('/consumibles', [ConsumibleController::class, 'index'])->name('consumibles.index');
    Route::get('/consumibles/crear', [ConsumibleController::class, 'crear'])->name('consumibles.crear');
    Route::post('/consumibles', [ConsumibleController::class, 'guardar'])->name('consumibles.guardar');
    Route::get('/consumibles/{id}/editar', [ConsumibleController::class, 'editar'])->name('consumibles.editar');
    Route::put('/consumibles/{id}', [ConsumibleController::class, 'actualizar'])->name('consumibles.actualizar');
    Route::delete('/consumibles/{id}', [ConsumibleController::class, 'eliminar'])->name('consumibles.eliminar');
});

// Rutas públicas (formularios) — solo accesibles para guests
Route::middleware('guest')->group(function () {
    Route::get('/login', function () {
        return view('auth.login');
    })->name('login');

    Route::get('/register', function () {
        return view('auth.register');
    })->name('register');
});

Route::get('/', function () {
    return auth()->check()
        ? redirect()->route('inventory.index')
        : redirect()->route('login');
});

// Eliminada la ruta catch-all que devolvía view('app')
// ya no hay Route::get('/{any}', ...) al final