@extends('layouts.app')

@section('content')
<h1>Crear Usuario</h1>

@if(session('status'))
    <div style="background: #10b981; color: white; padding: 10px; margin-bottom: 15px; border-radius: 5px;">
        {{ session('status') }}
    </div>
@endif

@if(session('error'))
    <div style="background: #ef4444; color: white; padding: 10px; margin-bottom: 15px; border-radius: 5px;">
        {{ session('error') }}
    </div>
@endif

<form method="POST" action="{{ route('admin.users.store') }}" style="max-width: 600px;">
    @csrf

    {{-- Nombre --}}
    <div style="margin-bottom: 20px;">
        <label for="name" style="display: block; font-weight: bold; margin-bottom: 5px;">Nombre</label>
        <input type="text" 
               id="name" 
               name="name" 
               value="{{ old('name') }}" 
               required
               style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
        @error('name') 
            <p style="color: red; font-size: 14px; margin-top: 5px;">{{ $message }}</p>
        @enderror
    </div>

    {{-- Email --}}
    <div style="margin-bottom: 20px;">
        <label for="email" style="display: block; font-weight: bold; margin-bottom: 5px;">Email</label>
        <input type="email" 
               id="email" 
               name="email" 
               value="{{ old('email') }}" 
               required
               style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
        @error('email') 
            <p style="color: red; font-size: 14px; margin-top: 5px;">{{ $message }}</p>
        @enderror
    </div>

    {{-- Rol --}}
    <div style="margin-bottom: 20px;">
        <label for="role" style="display: block; font-weight: bold; margin-bottom: 5px;">Rol</label>
        <select id="role" 
                name="role" 
                required
                style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
            <option value="">Seleccionar Rol</option>
            @foreach($roles as $role)
                <option value="{{ $role->name }}" {{ old('role') == $role->name ? 'selected' : '' }}>
                    {{ $role->name }}
                </option>
            @endforeach
        </select>
        @error('role') 
            <p style="color: red; font-size: 14px; margin-top: 5px;">{{ $message }}</p>
        @enderror
    </div>

    {{-- Contraseña --}}
    <div style="margin-bottom: 20px;">
        <label for="password" style="display: block; font-weight: bold; margin-bottom: 5px;">Contraseña</label>
        <input type="password" 
               id="password" 
               name="password" 
               required
               minlength="8"
               
               title="Mínimo 8 caracteres, incluyendo mayúsculas, minúsculas, números y caracteres especiales"
               style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
        @error('password') 
            <p style="color: red; font-size: 14px; margin-top: 5px;">{{ $message }}</p>
            
        @enderror
        <div style="font-size: 12px; color: #666; margin-top: 5px;">
            <strong>Requisitos:</strong><br>
            • Mínimo 8 caracteres<br>
            • Al menos una mayúscula<br>
            • Al menos una minúscula<br>
            • Al menos un número<br>
            • Al menos un carácter especial (@ $ ! % * ? &)
        </div>
    </div>

    {{-- Confirmar contraseña --}}
    <div style="margin-bottom: 20px;">
        <label for="password_confirmation" style="display: block; font-weight: bold; margin-bottom: 5px;">Confirmar Contraseña</label>
        <input type="password" 
               id="password_confirmation" 
               name="password_confirmation" 
               required
               style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
    </div>

    {{-- Botones --}}
    <div style="text-align: right; margin-top: 30px;">
        <a href="{{ route('admin.users') }}" 
           style="display: inline-block; padding: 10px 20px; border: 1px solid #ccc; text-decoration: none; margin-right: 10px; border-radius: 4px;">
            Cancelar
        </a>
        <button type="submit" 
                style="padding: 10px 20px; background: #3b82f6; color: white; border: none; border-radius: 4px; cursor: pointer;">
            Crear Usuario
        </button>
    </div>
</form>
@endsection
