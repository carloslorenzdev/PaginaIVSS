@extends('layouts.app-public')

@section('title', 'Archivo de Noticias - Prensa IVSS')

@section('content')
<div class="container py-5 mt-4">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-5 border-bottom pb-3 gap-3">
        <h2 class="fw-bold text-dark m-0">
            <i class="fas fa-newspaper text-danger mr-2"></i> ARCHIVO DE NOTICIAS
        </h2>
        
        <div class="d-flex align-items-center gap-3">
            <div class="position-relative">
                <i class="fas fa-search position-absolute top-50 start-0 translate-middle-y ms-3 text-muted"></i>
                <input type="text" id="buscador-noticias" class="form-control rounded-pill ps-5 border-0 shadow-sm" placeholder="Buscar noticia..." style="min-width: 300px; background: #F3F4F6; color: #1E293B; height: 45px; border: 1px solid rgba(0,0,0,0.05);">
            </div>
            <a href="/" class="btn-ultimate btn-ultimate-red">
                <i class="fas fa-arrow-left"></i> VOLVER
            </a>
        </div>
    </div>

    <div id="contenedor-noticias">
        @include('partials.noticias-lista')
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const buscador = document.getElementById('buscador-noticias');
            const contenedor = document.getElementById('contenedor-noticias');
            let timeout = null;

            buscador.addEventListener('input', function () {
                clearTimeout(timeout);
                timeout = setTimeout(function () {
                    const query = buscador.value;
                    fetch(`/noticias?search=${encodeURIComponent(query)}`, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => response.text())
                    .then(html => {
                        contenedor.innerHTML = html;
                    })
                    .catch(error => console.error('Error al buscar noticias:', error));
                }, 400);
            });
        });
    </script>
</div>
@endsection
