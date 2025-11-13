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

class AdminController extends Controller
{
    
    /**
     * Admin dashboard
     */
    public function dashboard(): View
    {
        $stats = [
            'total_users' => User::count(),
            'total_inventory' => Inventory::count(),
            'recent_users' => User::latest()->take(5)->get(),
            'recent_inventory' => Inventory::latest()->take(5)->get(),
        ];
        
        return view('admin.dashboard', compact('stats'));
    }
    
    /**
     * Display users list
     */
    public function users(Request $request): View
    {
        $search = $request->query('search');
        
        $users = User::query()
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', '%' . $search . '%')
                      ->orWhere('email', 'like', '%' . $search . '%');
                });
            })
            ->with('roles')
            ->orderBy('created_at', 'desc')
            ->paginate(10)
            ->withQueryString();
            
        $roles = Role::all();
        
        return view('admin.users.index', compact('users', 'search', 'roles'));
    }
    
    /**
     * Show create user form
     */
    public function createUser(): View
    {
        Gate::authorize('usuario crear');
        $roles = Role::all();
        return view('admin.users.create', compact('roles'));
    }
    
    /**
     * Store new user
     */
    public function storeUser(Request $request): RedirectResponse
    {
        Gate::authorize('usuario crear');
        
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', Password::defaults(), 'confirmed'],
            'role' => ['required', 'exists:roles,name'],
        ]);
        
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'email_verified_at' => now(),
        ]);
        
        $user->assignRole($validated['role']);
        
        return redirect()->route('admin.users')
            ->with('status', 'Usuario creado exitosamente.');
    }
    
    /**
     * Show edit user form
     */
    public function editUser(User $user): View
    {
        Gate::authorize('usuario modificar');
        $roles = Role::all();
        return view('admin.users.edit', compact('user', 'roles'));
    }
    
    /**
     * Update user
     */
    public function updateUser(Request $request, User $user): RedirectResponse
    {
        Gate::authorize('usuario modificar');
        
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'role' => ['required', 'exists:roles,name'],
            'password' => ['nullable', Password::defaults(), 'confirmed'],
        ]);
        
        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
        ]);
        
        if ($validated['password']) {
            $user->update([
                'password' => Hash::make($validated['password'])
            ]);
        }
        
        // Update role
        $user->syncRoles([$validated['role']]);
        
        return redirect()->route('admin.users')
            ->with('status', 'Usuario actualizado exitosamente.');
    }
    
    /**
     * Delete user
     */
    public function destroyUser(User $user): RedirectResponse
    {
        Gate::authorize('usuario eliminar');
        
        // Prevent deleting yourself
        if ($user->id === auth()->id()) {
            return redirect()->route('admin.users')
                ->with('error', 'No puedes eliminar tu propia cuenta desde el panel de administración.');
        }
        
        $user->delete();
        
        return redirect()->route('admin.users')
            ->with('status', 'Usuario eliminado exitosamente.');
    }
    
    /**
     * Display inventory management for admin
     */
    public function inventory(Request $request)
    {
        $search = $request->query('search');

        $inventories = Inventory::query()
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('brand', 'like', '%' . $search . '%')
                      ->orWhere('model', 'like', '%' . $search . '%')
                      ->orWhere('serial_number', 'like', '%' . $search . '%')
                      ->orWhere('printer_model', 'like', '%' . $search . '%');
                });
            })
            ->orderBy('created_at', 'desc')
            ->paginate(15)
            ->withQueryString();

        // Si la petición espera JSON (p. ej. Vue/axios), devolver JSON paginado
        if ($request->wantsJson() || $request->is('api/*') || $request->ajax()) {
            return response()->json($inventories);
        }

        return view('admin.inventory.index', compact('inventories', 'search'));
    }

    /**
     * Delete inventory item (API/Web)
     */
    public function destroyInventory(Request $request, Inventory $inventory)
    {
        Gate::authorize('inventario eliminar');

        // eliminar el registro
        $inventory->delete();

        if ($request->wantsJson() || $request->is('api/*') || $request->ajax()) {
            return response()->json(['message' => 'Elemento eliminado correctamente.'], 200);
        }

        return redirect()->route('admin.inventory')
            ->with('status', 'Elemento eliminado exitosamente.');
    }
}