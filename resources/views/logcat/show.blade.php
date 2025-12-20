@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
  <h1 class="text-xl mb-4">Detalle de actividad</h1>

  <dl>
    <dt>Fecha:</dt><dd>{{ $logcat->created_at }}</dd>
    <dt>Usuario:</dt><dd>{{ $logcat->user->name ?? '-' }}</dd>
    <dt>Acción:</dt><dd>{{ $logcat->accion }}</dd>

    <dt>IP:</dt><dd>{{ $logcat->ip }}</dd>
    @php
      $desc = $logcat->descripcion;
      $descArr = null;
      if (! empty($desc)) {
          $decoded = json_decode($desc, true);
          $descArr = is_array($decoded) ? $decoded : null;
      }
    @endphp

    <dt>Descripcion:</dt>
    <dd>
      @if($descArr)
        <ul class="list-disc ml-5">
          @foreach($descArr as $key => $value)
            <li>
              <strong>{{ $key }}:</strong>
              @if(is_array($value) || is_object($value))
                <pre style="white-space:pre-wrap;word-break:break-word">{{ json_encode($value, JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE) }}</pre>
              @else
                <span class="ml-2">{{ $value }}</span>
              @endif
            </li>
          @endforeach
        </ul>
      @else
        <pre style="white-space:pre-wrap;word-break:break-word">{{ $desc ?? '-' }}</pre>
      @endif
    </dd>
  </dl>

  <a href="{{ route('logcat.index') }}" class="inline-block mt-4 text-blue-600">Volver</a>
</div>
@endsection