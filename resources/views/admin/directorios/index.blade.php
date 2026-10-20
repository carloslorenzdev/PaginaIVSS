@extends('layouts/app')

@php
    $titulo = 'Directorios';
    if(request('tipo') == 'farmacia') $titulo = 'Farmacias';
    if(request('tipo') == 'centro_salud') $titulo = 'Centros de Salud';
    if(request('tipo') == 'oficina_administrativa') $titulo = 'Oficinas Administrativas';
@endphp

@section('titulo', $titulo)

@section('content')
    <livewire:admin.directorios-manager :tipo="request('tipo', 'centro_salud')" />
@endsection
