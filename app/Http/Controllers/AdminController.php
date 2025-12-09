<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Inventory;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Spatie\Permission\Models\Role;

class AdminController extends Controller {
// Mostrar lista de usuarios
public function users(Request $request)
{   
    $this->authorizeAdmin();

    $search = $request->query('search');
    
    $users = User::query()
        ->when($search, function ($query, $search) {
            $query->where('name', 'like', '%' . $search . '%')
                  ->orWhere('email', 'like', '%' . $search . '%');
        })
        ->with('roles')
        ->orderBy('created_at', 'desc')
        ->paginate(10)
        ->withQueryString();
    
    $roles = Role::all();

    return view('admin.users.index', compact('users', 'roles', 'search'));
    
}

    private function authorizeAdmin(): void
    {
        if (!auth()->check() || (auth()->user()->role ?? null) !== 'admin') {
            redirect()->back()->with('error', 'Acceso no autorizado. No tienes permisos para esta página.')->send();
            exit;
        }
    }


// Mostrar formulario crear
public function createUser()
{
    Gate::authorize('usuario crear');
    $roles = Role::all();
    return view('admin.users.create', compact('roles'));
}

// Guardar usuario
public function storeUser(Request $request)
{
    Gate::authorize('usuario crear');

    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => [
            'required',
            'confirmed',
            'min:8',
            'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]/',
            Password::defaults()
        ],
        'role' => ['required', 'exists:roles,name'],
    ], [
        'password.regex' => 'La contraseña debe incluir al menos una mayúscula, una minúscula, un número y un carácter especial (@ $ ! % * ? &).',
        'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
    ]);

    $user = User::create([
        'name' => $validated['name'],
        'email' => $validated['email'],
        'password' => Hash::make($validated['password']),
        'email_verified_at' => now(),
    ]);

    $user->assignRole($validated['role']);

    return redirect()->route('admin.users')->with('status', 'Usuario creado exitosamente.');
}

// Mostrar formulario editar
public function editUser(User $user)
{
    Gate::authorize('usuario modificar');
    $roles = Role::all();
    return view('admin.users.edit', compact('user', 'roles'));
}

// Actualizar usuario
public function updateUser(Request $request, User $user)
{
    Gate::authorize('usuario modificar');

    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255|unique:users,email,' . $user->id,
        'role' => 'required|exists:roles,name',
        'password' => ['nullable', 'confirmed', Password::defaults()],
    ]);

    $user->update([
        'name' => $validated['name'],
        'email' => $validated['email'],
    ]);

    if ($validated['password']) {
        $user->update(['password' => Hash::make($validated['password'])]);
    }

    $user->syncRoles([$validated['role']]);

    return redirect()->route('admin.users')->with('status', 'Usuario actualizado exitosamente.');
}

// Eliminar usuario
public function destroyUser(User $user)
{
    Gate::authorize('usuario eliminar');

    if ($user->id === auth()->id()) {
        return redirect()->route('admin.users')
            ->with('error', 'No puedes eliminar tu propia cuenta.');
    }

    $user->delete();

    return redirect()->route('admin.users')->with('status', 'Usuario eliminado exitosamente.');
}
}