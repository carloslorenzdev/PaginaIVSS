@extends('layouts.app-public')

@section('title', 'Archivo de Noticias - Prensa IVSS')

@section('content')
<div class="py-5" style="background-image: linear-gradient(rgba(243, 244, 246, 0.85), rgba(243, 244, 246, 0.85)), url('{{ asset('imagenes/fondo-ivss.png') }}'); background-size: cover; background-position: center; background-attachment: fixed; min-height: 100vh;">
    <div class="container mt-4">
        <livewire:noticias-search />
    </div>
</div>
@endsection
