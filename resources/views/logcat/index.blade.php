@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
  <h1 class="text-xl mb-4">Registros de actividad</h1>

  <table class="min-w-full bg-white">
    <thead>
      <tr>
        <th>Fecha</th>
        <th>Usuario</th>
        <th>Acción</th>
        <th>Sujeto / Ruta</th>
        <th>IP</th>
        <th></th>
      </tr>
    </thead>
    <tbody>
      @forelse($logs as $log)
        <tr>
          <td>{{ $log->created_at }}</td>
          <td>{{ $log->user->name ?? '-' }}</td>
          <td>{{ $log->accion }}</td>
          <td>{{ $log->tipo_sujeto ?? $log->propiedades['route'] ?? '-' }}</td>
          <td>{{ $log->ip }}</td>
          <td class="text-right">
            <a href="{{ route('logcat.show', $log) }}" class="text-blue-600">Ver</a>
            <form method="POST" action="{{ route('logcat.destroy', $log) }}" style="display:inline">
              @csrf @method('DELETE')
              <button type="submit" class="text-red-600 ml-2" onclick="return confirm('Eliminar registro?')">Eliminar</button>
            </form>
          </td>
        </tr>
      @empty
        <tr><td colspan="6">Sin registros</td></tr>
      @endforelse
    </tbody>
  </table>

  <div class="mt-4">{{ $logs->links() }}</div>
</div>
@endsection