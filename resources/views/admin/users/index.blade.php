@extends('layouts.app')

@section('content')
<h1>Usuarios</h1>

@if(session('status'))
    <div class="bg-green-500 text-white px-4 py-2 rounded mb-4">{{ session('status') }}</div>
@endif
@if(session('error'))
    <div class="bg-red-500 text-white px-4 py-2 rounded mb-4">{{ session('error') }}</div>
@endif

<a href="{{ route('admin.users.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded mb-4 inline-block">Crear Usuario</a>

<form method="GET" class="mb-4">
    <input type="text" name="search" value="{{ $search }}" placeholder="Buscar..." class="border p-2 rounded">
    <button type="submit" class="px-4 py-2 bg-gray-600 text-white rounded">Buscar</button>
</form>

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
                <a href="{{ route('admin.users.edit', $user->id) }}" class="text-blue-600">Editar</a>
                <form method="POST" action="{{ route('admin.users.destroy', $user->id) }}" onsubmit="return confirm('¿Eliminar usuario?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-red-600">Eliminar</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

{{ $users->links() }}
@endsection
