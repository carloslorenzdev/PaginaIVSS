<?php
$estados = [
    'Amazonas', 'Anzoátegui', 'Apure', 'Aragua', 'Barinas', 'Bolívar', 'Carabobo', 'Cojedes', 
    'Delta Amacuro', 'Distrito Capital', 'Falcón', 'Guárico', 'Lara', 'Mérida', 'Miranda', 
    'Monagas', 'Nueva Esparta', 'Portuguesa', 'Sucre', 'Táchira', 'Trujillo', 'Vargas', 'Yaracuy', 'Zulia'
];

$results = [];

foreach ($estados as $estado) {
    if ($estado === 'Distrito Capital') {
        $url = "http://www.ivss.gov.ve/contenido/Localizacion-Farmacias-IVSS:-Distrito-Capital";
    } else {
        $name = str_replace(' ', '-', $estado);
        $url = "http://www.ivss.gov.ve/contenido/Localizacion-Farmacias-IVSS:-Estado-" . $name;
    }
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36');
    $html = curl_exec($ch);
    $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($html) {
        preg_match('/<div class="contenido"[^>]*>(.*?)<\/div>/is', $html, $contentMatch);
        if (isset($contentMatch[1])) {
            $text = strip_tags(str_replace(['<br>', '<br/>', '<br />', '</p>', '</div>', '<li>', '<ul>'], "\n", $contentMatch[1]));
            $text = html_entity_decode($text);
            $text = preg_replace("/[\r\n]+/", "\n", trim($text));
            // Check if it's the generic news article
            if (strpos($text, 'compromiso patrio de las servidoras') === false) {
                $results[$estado] = $text;
            } else {
                $results[$estado] = "Could not parse correctly or generic article returned.";
            }
        }
    }
}

file_put_contents('c:/laragon/www/PaginaIVSS/scratch/states_curl.json', json_encode($results, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
echo "Scraped " . count($results) . " states.\n";
