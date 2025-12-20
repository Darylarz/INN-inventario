@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
  <h1 class="text-xl mb-4">Detalle de actividad</h1>

  <dl>
    <dt>Fecha</dt><dd>{{ $logcat->created_at }}</dd>
    <dt>Usuario</dt><dd>{{ $logcat->user->name ?? '-' }}</dd>
    <dt>Acción</dt><dd>{{ $logcat->accion }}</dd>
    <dt>Sujeto</dt><dd>{{ $logcat->tipo_sujeto }} #{{ $logcat->sujeto_id }}</dd>
    <dt>IP</dt><dd>{{ $logcat->ip }}</dd>
    <dt>User Agent</dt><dd>{{ $logcat->user_agent }}</dd>
    <dt>Descripción / Payload</dt><dd><pre>{{ json_encode($logcat->propiedades, JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE) }}</pre></dd>
  </dl>

  <a href="{{ route('logcat.index') }}" class="inline-block mt-4 text-blue-600">Volver</a>
</div>
@endsection