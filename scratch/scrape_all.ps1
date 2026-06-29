$estados = @(
    'Amazonas', 'Anzoategui', 'Apure', 'Aragua', 'Barinas', 'Bolivar', 'Carabobo', 'Cojedes', 
    'Delta-Amacuro', 'Distrito-Capital', 'Falcon', 'Guarico', 'Lara', 'Merida', 'Miranda', 
    'Monagas', 'Nueva-Esparta', 'Portuguesa', 'Sucre', 'Tachira', 'Trujillo', 'Vargas', 'Yaracuy', 'Zulia'
)

$results = @{}

foreach ($estado in $estados) {
    if ($estado -eq 'Distrito-Capital') {
        $url = "http://www.ivss.gov.ve/contenido/Localizacion-Farmacias-IVSS:-Distrito-Capital"
    } else {
        $url = "http://www.ivss.gov.ve/contenido/Localizacion-Farmacias-IVSS:-Estado-$estado"
    }
    
    try {
        $response = Invoke-WebRequest -Uri $url -UseBasicParsing -ErrorAction SilentlyContinue
        if ($response) {
            $html = $response.Content
            # Extract content from <div class="contenido"...>
            if ($html -match '(?si)<div class="contenido"[^>]*>(.*?)</div>') {
                $text = $matches[1] -replace '<br\s*/?>', "`n" -replace '<[^>]+>', '' -replace '&nbsp;', ' ' -replace '^\s+|\s+$', '' -replace '\n+', "`n"
                $results[$estado] = $text
            }
        }
    } catch {}
}

$results | ConvertTo-Json -Depth 5 | Out-File -FilePath c:\laragon\www\PaginaIVSS\scratch\real_data.json -Encoding utf8
