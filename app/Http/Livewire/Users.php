<?php

namespace App\Livewire\Admin;


use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class Users extends Component
{
    use WithPagination;

    public $search = '';
    public $name, $email, $password, $password_confirmation, $role;
    public $editing = false;
    public $userId;
    public $roles;

    protected $paginationTheme = 'tailwind';

    protected $listeners = [
        'confirmDelete'
    ];

    public function mount()
    {
        $this->roles = Role::all();
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $users = User::query()
            ->where(function($q) {
                $q->where('name', 'like', "%{$this->search}%")
                  ->orWhere('email', 'like', "%{$this->search}%");
            })
            ->with('roles')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('livewire.admin.users', compact('users'));
    }

    // --- Crear usuario ---
    public function create()
    {
        $this->resetFields();
        $this->editing = false;
    }

    public function store()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => ['required', Password::defaults(), 'confirmed'],
            'role' => 'required|exists:roles,name',
        ]);

        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
            'email_verified_at' => now(),
        ]);

        $user->assignRole($this->role);

        $this->dispatch('alert', [
            'type' => 'success',
            'message' => 'Usuario creado exitosamente'
        ]);

        $this->resetFields();
    }

    // --- Editar usuario ---
    public function edit(User $user)
    {
        $this->editing = true;
        $this->userId = $user->id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->role = $user->roles->first()?->name;
    }

    public function update()
    {
        $user = User::findOrFail($this->userId);

        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'role' => 'required|exists:roles,name',
            'password' => ['nullable', Password::defaults(), 'confirmed'],
        ]);

        $user->update([
            'name' => $this->name,
            'email' => $this->email
        ]);

        if ($this->password) {
            $user->update(['password' => Hash::make($this->password)]);
        }

        $user->syncRoles([$this->role]);

        $this->dispatch('alert', [
            'type' => 'success',
            'message' => 'Usuario actualizado exitosamente'
        ]);

        $this->resetFields();
    }

    // --- Confirmación eliminar ---
    public function delete($id)
    {
        $this->dispatch('confirmDelete', $id);
    }

    public function confirmDelete($id)
    {
        $user = User::findOrFail($id);

        if ($user->id == auth()->id()) {
            return $this->dispatch('alert', [
                'type' => 'error',
                'message' => 'No puedes eliminar tu propia cuenta'
            ]);
        }

        $user->delete();

        $this->dispatch('alert', [
            'type' => 'success',
            'message' => 'Usuario eliminado'
        ]);
    }

    // Reset fields
    private function resetFields()
    {
        $this->name = $this->email = $this->password = $this->password_confirmation = '';
        $this->role = null;
        $this->editing = false;
        $this->userId = null;
    }
}
