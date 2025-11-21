<div class="p-6">

    {{-- Buscador --}}
    <input type="text" wire:model="search" placeholder="Buscar usuario..."
           class="border rounded px-3 py-2 w-full mb-4">

    {{-- Botón crear --}}
    <button wire:click="create"
        class="bg-blue-600 text-white px-4 py-2 rounded mb-4">
        Crear Usuario
    </button>

    {{-- Tabla --}}
    <table class="w-full border">
        <thead>
            <tr class="bg-gray-100">
                <th class="p-2">Nombre</th>
                <th class="p-2">Email</th>
                <th class="p-2">Rol</th>
                <th class="p-2">Acciones</th>
            </tr>
        </thead>

        <tbody>
        @foreach($users as $user)
            <tr class="border-t">
                <td class="p-2">{{ $user->name }}</td>
                <td class="p-2">{{ $user->email }}</td>
                <td class="p-2">{{ $user->roles->first()?->name }}</td>
                <td class="p-2 flex gap-2">

                    <button wire:click="edit({{ $user->id }})"
                        class="text-blue-600">
                        Editar
                    </button>

                    <button wire:click="delete({{ $user->id }})"
                        class="text-red-600">
                        Eliminar
                    </button>

                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    {{ $users->links() }}

    {{-- Modal Crear/Editar --}}
    @if($editing || $userId === null)
    <div class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center">
        <div class="bg-white p-6 rounded w-full max-w-md">

            <h2 class="text-xl font-bold mb-4">
                {{ $editing ? 'Editar Usuario' : 'Crear Usuario' }}
            </h2>

            <input type="text" wire:model="name" placeholder="Nombre" class="w-full border mb-3 p-2">
            <input type="email" wire:model="email" placeholder="Email" class="w-full border mb-3 p-2">

            <select wire:model="role" class="w-full border mb-3 p-2">
                <option value="">Seleccionar Rol</option>
                @foreach ($roles as $role)
                    <option value="{{ $role->name }}">{{ $role->name }}</option>
                @endforeach
            </select>

            <input type="password" wire:model="password" placeholder="Contraseña" class="w-full border mb-3 p-2">
            <input type="password" wire:model="password_confirmation" placeholder="Confirmar Contraseña" class="w-full border mb-3 p-2">

            <div class="flex justify-end gap-2">
                <button wire:click="resetFields" class="px-4 py-2">Cancelar</button>

                @if($editing)
                    <button wire:click="update" class="bg-blue-600 text-white px-4 py-2 rounded">
                        Actualizar
                    </button>
                @else
                    <button wire:click="store" class="bg-green-600 text-white px-4 py-2 rounded">
                        Crear
                    </button>
                @endif
            </div>
        </div>
    </div>
    @endif

</div>

{{-- Alertas Livewire --}}
<script>
    Livewire.on('alert', event => {
        alert(event.message);
    });

    Livewire.on('confirmDelete', userId => {
        if (confirm("¿Seguro que deseas eliminar este usuario?")) {
            Livewire.dispatch('confirmDelete', userId);
        }
    });
</script>
