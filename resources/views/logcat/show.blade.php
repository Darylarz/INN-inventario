@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6 max-w-4xl">
  <h1 class="text-2xl font-semibold text-gray-800 dark:text-gray-100 mb-6">
    Detalle de actividad
  </h1>

  <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
    <dl class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
      <dt class="font-semibold text-gray-600 dark:text-gray-300">Fecha</dt>
      <dd class="md:col-span-2 text-gray-800 dark:text-gray-100">
        {{ $logcat->created_at }}
      </dd>

      <dt class="font-semibold text-gray-600 dark:text-gray-300">Usuario</dt>
      <dd class="md:col-span-2 text-gray-800 dark:text-gray-100">
        {{ $logcat->user->name ?? '-' }}
      </dd>

      <dt class="font-semibold text-gray-600 dark:text-gray-300">Acción</dt>
      <dd class="md:col-span-2">
        <span class="inline-block px-2 py-1 rounded bg-blue-100 text-blue-800 text-xs">
          {{ $logcat->accion }}
        </span>
      </dd>

      <dt class="font-semibold text-gray-600 dark:text-gray-300">IP</dt>
      <dd class="md:col-span-2 text-gray-800 dark:text-gray-100">
        {{ $logcat->ip }}
      </dd>
    </dl>

    @php
      $desc = $logcat->descripcion;
      $descArr = null;
      if (!empty($desc)) {
          $decoded = json_decode($desc, true);
          $descArr = is_array($decoded) ? $decoded : null;
      }
    @endphp

    <div class="mt-6">
      <h2 class="font-semibold text-gray-700 dark:text-gray-200 mb-2">
        Descripción
      </h2>

      @if($descArr)
        <ul class="space-y-3 text-sm">
          @foreach($descArr as $key => $value)
            <li class="bg-gray-50 dark:bg-gray-700 p-3 rounded">
              <span class="font-semibold text-gray-700 dark:text-gray-200">
                {{ $key }}:
              </span>

              @if(is_array($value) || is_object($value))
                <pre class="mt-2 text-xs bg-black/80 text-green-200 p-3 rounded overflow-x-auto">
{{ json_encode($value, JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE) }}
                </pre>
              @else
                <span class="ml-2 text-gray-800 dark:text-gray-100">
                  {{ $value }}
                </span>
              @endif
            </li>
          @endforeach
        </ul>
      @else
        <pre class="text-sm bg-gray-100 dark:bg-gray-700 p-4 rounded overflow-x-auto">
{{ $desc ?? '-' }}
        </pre>
      @endif
    </div>

    <div class="mt-6">
      <a href="{{ route('logcat.index') }}"
         class="inline-flex items-center px-4 py-2 bg-gray-200 dark:bg-gray-700
                text-gray-800 dark:text-gray-100 rounded hover:bg-gray-300 dark:hover:bg-gray-600">
        ← Volver
      </a>
    </div>
  </div>
</div>
@endsection
