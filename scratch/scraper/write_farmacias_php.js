const fs = require('fs');
const data = JSON.parse(fs.readFileSync('c:/laragon/www/PaginaIVSS/scratch/scraper/farmacias_final.json', 'utf8'));

const estados = [
    "Amazonas", "Anzoategui", "Apure", "Aragua", "Barinas", "Bolivar",
    "Carabobo", "Cojedes", "Delta-Amacuro", "Distrito-Capital", "Falcon",
    "Guarico", "Lara", "Merida", "Miranda", "Monagas", "Nueva-Esparta",
    "Portuguesa", "Sucre", "Tachira", "Trujillo", "Vargas", "Yaracuy", "Zulia"
];

let output = `
@extends('layouts.app')

@section('title', 'Localización Farmacias IVSS')

@section('content')
<style>
    .banner-farmacias {
        background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('{{ asset("imag/banner/banner_farmacias.jpg") }}') center/cover;
        color: white;
        padding: 60px 20px;
        text-align: center;
        border-radius: 12px;
        margin-bottom: 40px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }

    .banner-farmacias h1 {
        font-weight: 700;
        font-size: 2.5rem;
        margin-bottom: 10px;
    }

    .banner-farmacias p {
        font-size: 1.1rem;
        opacity: 0.9;
    }

    .grid-estados {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: 20px;
        margin-bottom: 50px;
    }

    .card-estado {
        background: white;
        border-radius: 10px;
        padding: 20px;
        text-align: center;
        box-shadow: 0 4px 6px rgba(0,0,0,0.05);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        border: 1px solid #eaeaea;
        cursor: pointer;
    }

    .card-estado:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 15px rgba(0,0,0,0.1);
        border-color: #009CDF;
    }

    .card-estado i {
        font-size: 2rem;
        color: #009CDF;
        margin-bottom: 15px;
    }

    .card-estado h3 {
        margin: 0;
        font-size: 1.2rem;
        color: #333;
    }

    /* Modal Styles */
    .modal-overlay {
        position: fixed;
        top: 0; left: 0; width: 100%; height: 100%;
        background: rgba(0,0,0,0.6);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 1000;
        opacity: 0;
        visibility: hidden;
        transition: opacity 0.3s ease, visibility 0.3s ease;
        backdrop-filter: blur(4px);
    }
    .modal-overlay.active {
        opacity: 1;
        visibility: visible;
    }
    .modal-content {
        background: #fff;
        border-radius: 16px;
        width: 90%;
        max-width: 700px;
        max-height: 85vh;
        overflow-y: auto;
        box-shadow: 0 20px 40px rgba(0,0,0,0.2);
        transform: scale(0.95);
        transition: transform 0.3s ease;
    }
    .modal-overlay.active .modal-content {
        transform: scale(1);
    }
    .modal-header {
        background: linear-gradient(135deg, #009CDF, #0056b3);
        color: white;
        padding: 25px 30px;
        position: relative;
        border-top-left-radius: 16px;
        border-top-right-radius: 16px;
        text-align: center;
    }
    .modal-header h2 {
        margin: 0;
        font-size: 1.8rem;
        font-weight: 600;
        letter-spacing: 0.5px;
    }
    .close-modal {
        position: absolute;
        top: 20px;
        right: 25px;
        background: rgba(255,255,255,0.2);
        border: none;
        color: white;
        font-size: 1.5rem;
        width: 36px; height: 36px;
        border-radius: 50%;
        cursor: pointer;
        transition: background 0.2s, transform 0.2s;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .close-modal:hover {
        background: rgba(255,255,255,0.4);
        transform: rotate(90deg);
    }
    .modal-body {
        padding: 30px;
        background: #f8fbff;
    }
    
    .farmacia-card {
        background: white;
        border-left: 5px solid #009CDF;
        border-radius: 8px;
        padding: 20px;
        margin-bottom: 20px;
        box-shadow: 0 3px 10px rgba(0,0,0,0.04);
        transition: transform 0.2s;
    }
    .farmacia-card:hover {
        transform: translateX(5px);
    }
    .farmacia-title {
        color: #0056b3;
        font-size: 1.25rem;
        font-weight: 700;
        margin-bottom: 12px;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .farmacia-title i {
        color: #e74c3c;
    }
    .farmacia-info {
        display: flex;
        align-items: flex-start;
        gap: 12px;
        margin-bottom: 10px;
        color: #555;
        font-size: 1rem;
        line-height: 1.5;
    }
    .farmacia-info i {
        color: #009CDF;
        margin-top: 4px;
        min-width: 16px;
    }
    .no-data-msg {
        text-align: center;
        padding: 40px 20px;
        color: #666;
        background: #fff;
        border-radius: 8px;
        border: 2px dashed #ccc;
    }
    .no-data-msg i {
        font-size: 3rem;
        color: #ccc;
        margin-bottom: 15px;
    }
</style>

<div class="container mt-4">
    <div class="banner-farmacias">
        <h1>Directorio de Farmacias IVSS</h1>
        <p>Seleccione su estado para conocer las farmacias disponibles en su región.</p>
    </div>

    <div class="grid-estados">
`;

for (let e of estados) {
    let key = e.replace('-', ' ');
    if (e === "Nueva-Esparta") key = "Nueva Esparta";
    
    output += `
        <div class="card-estado" onclick="openModal('${e}')">
            <i class="fas fa-map-marker-alt"></i>
            <h3>${key}</h3>
        </div>
    `;
}

output += `
    </div>
</div>

<div class="modal-overlay" id="estadoModal">
    <div class="modal-content">
        <div class="modal-header">
            <h2 id="modalTitle">Estado</h2>
            <button class="close-modal" onclick="closeModal()"><i class="fas fa-times"></i></button>
        </div>
        <div class="modal-body" id="modalBody">
            <!-- Content injected via JS -->
        </div>
    </div>
</div>

<script>
    const farmaciasData = {
`;

for (let e of estados) {
    let key = e.replace('-', ' ');
    if (e === "Nueva-Esparta") key = "Nueva Esparta";
    
    let arr = data[key] || [];
    output += `        "${e}": [\n`;
    for (let c of arr) {
        output += `            { nombre: "${c.nombre.replace(/"/g, '\\"')}", direccion: "${c.direccion.replace(/"/g, '\\"')}", telefono: "${c.telefono.replace(/"/g, '\\"')}" },\n`;
    }
    output += `        ],\n`;
}

output += `    };

    function openModal(estado) {
        const modal = document.getElementById('estadoModal');
        const title = document.getElementById('modalTitle');
        const body = document.getElementById('modalBody');
        
        let nombreEstado = estado.replace('-', ' ');
        if(estado === 'Nueva-Esparta') nombreEstado = 'Nueva Esparta';
        
        title.innerText = 'Farmacias IVSS - Estado ' + nombreEstado;
        
        const data = farmaciasData[estado];
        let html = '';
        
        if (data && data.length > 0) {
            data.forEach(item => {
                html += \`
                    <div class="farmacia-card">
                        <div class="farmacia-title"><i class="fas fa-prescription-bottle-alt"></i> \${item.nombre}</div>
                        <div class="farmacia-info">
                            <i class="fas fa-map-marked-alt"></i>
                            <div>\${item.direccion}</div>
                        </div>
                        <div class="farmacia-info">
                            <i class="fas fa-phone-alt"></i>
                            <div>\${item.telefono}</div>
                        </div>
                    </div>
                \`;
            });
        } else {
            html = \`
                <div class="no-data-msg">
                    <i class="fas fa-info-circle"></i>
                    <p>No se encuentra esta información disponible en este momento.</p>
                </div>
            \`;
        }
        
        body.innerHTML = html;
        modal.classList.add('active');
    }

    function closeModal() {
        document.getElementById('estadoModal').classList.remove('active');
    }

    // Close when clicking outside
    document.getElementById('estadoModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeModal();
        }
    });
</script>
@endsection
`;

fs.writeFileSync('c:/laragon/www/PaginaIVSS/resources/views/publico/farmacias/index.blade.php', output);
