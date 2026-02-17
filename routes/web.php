<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\InventoryManagementController;
use Illuminate\Support\Facades\Route; // tambien es ruta del sidebar//
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Validation\ValidationException;
use App\Http\Middleware\SessionTimeout; // <-- añadir

use App\Http\Controllers\ArticuloHardwareController;
use App\Http\Controllers\HerramientaController;
use App\Http\Controllers\ConsumibleController;
use App\Http\Controllers\reportesController;
use App\Http\Controllers\logcatController;
use App\Http\Middleware\logcatMiddleware;


// raíz -> redirigir al dashboard (Blade)
use App\Http\Controllers\inventarioController;
use App\Http\Controllers\movimientoInventarioController;
use App\Http\Controllers\categoriaController;
use App\Http\Controllers\ubicacionController;



// LOGIN
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
    return redirect()->route('inventario.index');
});

// REGISTER (POST existente ajustado)
Route::post('/register', function (Request $request) {
    $data = $request->validate([
        'name' => ['required', 'string'],
        'email' => ['required', 'email', 'unique:users,email'],
        'password' => ['required', 'confirmed', 'min:8'],
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
})->name('logout');


/*
|--------------------------------------------------------------------------
| RUTAS PROTEGIDAS
|--------------------------------------------------------------------------
*/

// aplicar middleware por clase (ya usas SessionTimeout); añade logcat::class al grupo auth
Route::middleware(['auth', SessionTimeout::class, logcatMiddleware::class])->group(function () {
    // Keep-alive para extender sesión desde el cliente
    Route::post('/session/keep-alive', function (\Illuminate\Http\Request $request) {
        $request->session()->put('lastActivityTime', time());
        return response()->json(['ok' => true]);
    })->name('session.keepalive');

    // ahora la ruta /dashboard devuelve la vista Blade que monta Livewire
    
Route::get('/dashboard', [inventarioController::class, 'index'])->name('dashboard');

    Route::prefix('inventario')->name('inventario.')->group(function () {
        Route::get('/', [inventarioController::class, 'index'])->name('index');
        Route::get('/disabled', [inventarioController::class, 'disabledIndex'])->name('disabled');
        Route::post('/{inventario}/disable', [inventarioController::class, 'disable'])->name('disable');
        Route::post('/{inventario}/enable', [inventarioController::class, 'enable'])->name('enable');

        Route::get('/create', [inventarioController::class, 'create'])->name('create');
        Route::post('/store', [inventarioController::class, 'store'])->name('store');
        Route::get('/{inventario}/edit', [inventarioController::class, 'edit'])->name('edit');
        Route::put('/{inventario}', [inventarioController::class, 'update'])->name('update');
        Route::delete('/{inventario}', [inventarioController::class, 'destroy'])->name('destroy');
        Route::get('/{inventario}', [inventarioController::class, 'show'])->name('show');
    });

    // Reports
    Route::get('/reportes', [reportesController::class, 'index'])->name('reportes.index');
    Route::post('/reportes/pdf', [reportesController::class, 'pdf'])->name('reportes.pdf');


    Route::get('/{inventario}/entrada', [movimientoInventarioController::class, 'crearEntrada'])->name('inventario.entrada.create');
        Route::post('/{inventario}/entrada', [movimientoInventarioController::class, 'guardarEntrada'])->name('inventario.entrada.store');
        Route::get('/{inventario}/salida', [movimientoInventarioController::class, 'crearSalida'])->name('inventario.salida.create');
        Route::post('/{inventario}/salida', [movimientoInventarioController::class, 'guardarSalida'])->name('inventario.salida.store');
    // Admin
    
        Route::get('/users', [AdminController::class, 'users'])->middleware('can:usuario crear')->name('admin.users');
    Route::get('/users/create', [AdminController::class, 'createUser'])->name('admin.users.create');
    Route::post('/users', [AdminController::class, 'storeUser'])->name('admin.users.store');
    Route::get('/users/{user}/edit', [AdminController::class, 'editUser'])->name('admin.users.edit');
    Route::put('/users/{user}', [AdminController::class, 'updateUser'])->name('admin.users.update');
    Route::delete('/users/{user}', [AdminController::class, 'destroyUser'])->name('admin.users.destroy');

    // Ruta para desactivar usuarios
    Route::post('/admin/users/{user}/deactivate', [AdminController::class, 'deactivateUser'])->name('admin.users.deactivate');

// Ubicaciones
    Route::prefix('ubicaciones')->name('ubicaciones.')->middleware('can:usuario crear')->group(function () {
        Route::get('/', [ubicacionController::class, 'index'])->name('index');
        Route::get('/create', [ubicacionController::class, 'create'])->name('create');
        Route::post('/', [ubicacionController::class, 'store'])->name('store');
        Route::get('/{ubicacion}/edit', [ubicacionController::class, 'edit'])->name('edit');
        Route::put('/{ubicacion}', [ubicacionController::class, 'update'])->name('update');
        Route::delete('/{ubicacion}', [ubicacionController::class, 'destroy'])->name('destroy');
        Route::post('/{ubicacion}/deactivate', [ubicacionController::class, 'deactivate'])->name('deactivate');
    });


     // Categorías (Tipos de inventario)
    Route::prefix('categorias')->name('categorias.')->middleware('can:usuario crear')->group(function () {
        Route::get('/', [categoriaController::class, 'index'])->name('index');
        Route::get('/create', [categoriaController::class, 'create'])->name('create');
        Route::post('/', [categoriaController::class, 'store'])->name('store');
        Route::get('/{categoria}/edit', [categoriaController::class, 'edit'])->name('edit');
        Route::put('/{categoria}', [categoriaController::class, 'update'])->name('update');
        Route::delete('/{categoria}', [categoriaController::class, 'destroy'])->name('destroy');
        Route::post('/{categoria}/deactivate', [categoriaController::class, 'deactivate'])->name('deactivate');
    });

    // Activity logs (logcat) (ver / eliminar)
    Route::middleware('can:usuario crear')->group(function () {
    Route::get('logcat', [logcatController::class, 'index'])->name('logcat.index');
    Route::get('logcat/{logcat}', [logcatController::class, 'show'])->name('logcat.show');
    Route::delete('logcat/{logcat}', [logcatController::class, 'destroy'])->name('logcat.destroy');
    Route::post('/logcat/{logcat}/deactivate', [logcatController::class, 'deactivate'])->name('logcat.deactivate');
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
        ? redirect()->route('inventario.index')
        : redirect()->route('login');
});

// Eliminada la ruta catch-all que devolvía view('app')
// ya no hay Route::get('/{any}', ...) al final