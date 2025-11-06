@extends('layout/Ilayout')
desde indice de inventario

@section('content')

{{-- Este botón solo lo ve el Administrador (porque solo él tiene el permiso de eliminar) --}}
@can('articulo eliminar')
    <button>Eliminar Artículo</button>
@endcan

{{-- Este botón lo ven ambos roles --}}
@can('articulo agregar')
    <button>Añadir Nuevo Artículo</button>
@endcan

        @endsection
