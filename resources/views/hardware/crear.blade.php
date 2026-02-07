@extends('layouts.app')

@section('header', 'Nuevo Artículo de Hardware')

@section('content')
<div class="max-w-3xl mx-auto bg-white shadow rounded p-6 mt-6">
    <form action="{{ route('hardware.guardar') }}" method="POST" class="space-y-4">
        @csrf
        @include('hardware.form')
        <button class="mt-4 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Guardar</button>
    </form>
</div>
@endsection
