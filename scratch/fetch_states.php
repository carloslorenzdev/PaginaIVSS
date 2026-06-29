<?php
$estados = [
    'Amazonas', 'Anzoátegui', 'Apure', 'Aragua', 'Barinas', 'Bolívar', 'Carabobo', 'Cojedes', 
    'Delta Amacuro', 'Distrito Capital', 'Falcón', 'Guárico', 'Lara', 'Mérida', 'Miranda', 
    'Monagas', 'Nueva Esparta', 'Portuguesa', 'Sucre', 'Táchira', 'Trujillo', 'Vargas', 'Yaracuy', 'Zulia'
];

$results = [];

// Base URLs structure usually:
// http://www.ivss.gov.ve/contenido/Localizacion-Farmacias-IVSS:-Estado-[Name]
// Space becomes %20 or - ? Let's check the screenshot of the browser subagent for Distrito Capital:
// The URL was http://www.ivss.gov.ve/contenido/Localizacion-Farmacias-IVSS:-Distrito-Capital or similar.
// Wait, the user's active page is:
// http://www.ivss.gov.ve/contenido/Localizacion-Farmacias-IVSS:-Distrito-Capital

foreach ($estados as $estado) {
    if ($estado === 'Distrito Capital') {
        $url = "http://www.ivss.gov.ve/contenido/Localizacion-Farmacias-IVSS:-Distrito-Capital";
    } else {
        // e.g. Localizacion-Farmacias-IVSS-Estado-Sucre or Localizacion-Farmacias-IVSS:-Estado-Miranda
        $name = str_replace(' ', '-', $estado);
        $url = "http://www.ivss.gov.ve/contenido/Localizacion-Farmacias-IVSS:-Estado-" . $name;
    }
    
    // There are some variations like "Localizacion-Farmacias-IVSS-Estado-Sucre" (without colon)
    
    $html = @file_get_contents($url);
    if (!$html) {
        $url2 = "http://www.ivss.gov.ve/contenido/Localizacion-Farmacias-IVSS-Estado-" . $name;
        $html = @file_get_contents($url2);
    }
    if (!$html) {
        $url3 = "http://www.ivss.gov.ve/contenido/Localizacion-Farmacias-IVSS-Estado-" . urlencode($estado);
        $html = @file_get_contents($url3);
    }

    if ($html) {
        preg_match('/<div class="contenido"[^>]*>(.*?)<\/div>/is', $html, $contentMatch);
        if (isset($contentMatch[1])) {
            $text = strip_tags(str_replace(['<br>', '<br/>', '<br />', '</p>', '</div>', '<li>', '<ul>'], "\n", $contentMatch[1]));
            $text = html_entity_decode($text);
            $text = preg_replace("/[\r\n]+/", "\n", trim($text));
            $results[$estado] = $text;
        }
    }
}

file_put_contents('c:/laragon/www/PaginaIVSS/scratch/states_data.json', json_encode($results, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
echo "Scraped " . count($results) . " states.\n";
