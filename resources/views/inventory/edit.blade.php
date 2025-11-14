@extends('layouts.app')

@section('content')
  {{-- Se pasa $inventory desde la ruta --}}
  @livewire('inventory-edit', ['inventory' => $inventory])
@endsecti