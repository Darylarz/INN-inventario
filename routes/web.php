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

// raíz -> redirigir al dashboard (Blade)
Route::get('/', function () {
    return redirect()->route('dashboard');
});

/*
|--------------------------------------------------------------------------
| LOGIN / REGISTER / LOGOUT (PARA TU SPA)
|--------------------------------------------------------------------------
*/

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
    // Temporal: redirigir al dashboard después de "login"
    return redirect()->route('dashboard');
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
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // RUTAS DE INVENTARIO (GET devuelven vistas Blade que montan Livewire)
    Route::get('/i', function () {
        return redirect()->route('dashboard'); // o view('inventory.index') si quieres página de índice separada
    })->name('inventario-index');

    Route::get('/i/create', function () {
        return view('inventory.create');
    })->name('inventario-create');

    // Mantener store/update/destroy en el controlador
    Route::post('/i', [InventoryManagementController::class, 'store'])->name('inventario-store');

    Route::get('/i/{inventory}/edit', function (\App\Models\Inventory $inventory) {
        return view('inventory.edit', compact('inventory'));
    })->name('inventario-edit');

    Route::put('/i/{inventory}', [InventoryManagementController::class, 'update'])->name('inventario-update');
    Route::delete('/i/{inventory}', [InventoryManagementController::class, 'destroy'])->name('inventario-destroy');

    // Admin
    Route::middleware('permission:admin panel')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::get('/users', [AdminController::class, 'users'])->name('users');
        Route::post('/users', [AdminController::class, 'storeUser'])->name('users.store');
        // resto de admin...
    });
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

// Eliminada la ruta catch-all que devolvía view('app')
// ya no hay Route::get('/{any}', ...) al final
