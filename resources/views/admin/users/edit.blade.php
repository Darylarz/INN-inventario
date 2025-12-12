@extends('layouts.app')

@section('content')
<h1>Editar Usuario</h1>

@if(session('status'))
    <div class="bg-green-500 text-white px-4 py-2 rounded mb-4">{{ session('status') }}</div>
@endif
@if(session('error'))
    <div class="bg-red-500 text-white px-4 py-2 rounded mb-4">{{ session('error') }}</div>
@endif

<form method="POST" action="{{ route('admin.users.update', $user->id) }}" class="max-w-md">
    @csrf
    @method('PUT')

    {{-- Nombre --}}
    <div class="mb-4">
        <label for="name" class="block font-bold mb-1">Nombre</label>
        <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" 
               class="w-full border p-2 rounded">
        @error('name') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
    </div>

    {{-- Email --}}
    <div class="mb-4">
        <label for="email" class="block font-bold mb-1">Email</label>
        <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" 
               class="w-full border p-2 rounded">
        @error('email') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
    </div>

    {{-- Rol --}}
    <div class="mb-4">
        <label for="role" class="block font-bold mb-1">Rol</label>
        <select id="role" name="role" class="w-full border p-2 rounded">
            <option value="">Seleccionar Rol</option>
            @foreach($roles as $role)
                <option value="{{ $role->name }}" {{ (old('role', $user->roles->first()?->name) == $role->name) ? 'selected' : '' }}>
                    {{ $role->name }}
                </option>
            @endforeach
        </select>
        @error('role') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
    </div>

    {{-- Contraseña (opcional) --}}
    <div class="mb-4">
        <label for="password" class="block font-bold mb-1">Nueva Contraseña (opcional)</label>
        <input type="password" id="password" name="password" class="w-full border p-2 rounded">
        @error('password') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
    </div>

    {{-- Confirmar contraseña --}}
    <div class="mb-4">
        <label for="password_confirmation" class="blo#ck font-bold mb-1">Confirmar Nueva Contraseña</label>
        <input type="password" id="password_confirmation" name="password_confirmation" class="w-full border p-2 rounded">
    </div>

    {{-- Botón --}}
    <div class="flex justify-end gap-2">
        <a href="{{ route('admin.users') }}" class="px-4 py-2 border rounded">Cancelar</a>
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Actualizar Usuario</button>
    </div>
</form>
@endsection