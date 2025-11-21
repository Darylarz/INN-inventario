@extends('layouts.app')

@section('header', 'Editar Artículo de Hardware')

@section('content')
<div class="max-w-3xl mx-auto bg-white shadow rounded p-6 mt-6">
    <form action="{{ route('hardware.actualizar', $articulo->id) }}" method="POST">
        @csrf
        @method('PUT')
        @include('hardware.form', ['articulo' => $articulo])
        <button class="mt-4 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Actualizar</button>
    </form>
</div>
@endsection
