@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-8 space-y-6">

    {{-- Header --}}
    <div class="flex items-center justify-between">
        <h1 class="text-3xl font-bold text-gray-800 dark:text-gray-100">
            Registros de actividad
        </h1>
    </div>

    {{-- Tabla --}}
    <div class="bg-white dark:bg-gray-900 rounded-xl shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-gray-50 dark:bg-gray-800 text-gray-600 dark:text-gray-300">
                    <tr>
                        <th class="px-4 py-3 text-left">Fecha</th>
                        <th class="px-4 py-3 text-left">Usuario</th>
                        <th class="px-4 py-3 text-left">Acción</th>
                        <th class="px-4 py-3 text-left">Sujeto / Ruta</th>
                        <th class="px-4 py-3 text-left">IP</th>
                        <th class="px-4 py-3 text-right">Acciones</th>
                    </tr>
                </thead>

                <tbody class="divide-y dark:divide-gray-800">
                    @forelse($logs as $log)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-800">
                            <td class="px-4 py-3 text-gray-500">
                                {{ $log->created_at->format('Y-m-d H:i') }}
                            </td>

                            <td class="px-4 py-3">
                                {{ $log->user->name ?? '-' }}
                            </td>

                            <td class="px-4 py-3">
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold
                                    bg-indigo-100 text-indigo-800 dark:bg-indigo-900 dark:text-indigo-200">
                                    {{ ucfirst($log->accion) }}
                                </span>
                            </td>

                            <td class="px-4 py-3 text-gray-600 dark:text-gray-300 truncate max-w-xs">
                                {{ $log->tipo_sujeto ?? $log->propiedades['route'] ?? '-' }}
                            </td>

                            <td class="px-4 py-3 text-gray-500">
                                {{ $log->ip }}
                            </td>

                            <td class="px-4 py-3 text-right space-x-3">
                                <a href="{{ route('logcat.show', $log) }}"
                                   class="text-indigo-600 hover:underline">
                                    Ver
                                </a>

                                <form method="POST"
                                      action="{{ route('logcat.destroy', $log) }}"
                                      class="inline-block"
                                      onsubmit="return confirm('¿Eliminar registro?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="text-red-600 hover:text-red-800">
                                        Eliminar
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-8 text-gray-500">
                                Sin registros de actividad
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Paginación --}}
    <div class="pt-4">
        {{ $logs->links() }}
    </div>

</div>
@endsection
