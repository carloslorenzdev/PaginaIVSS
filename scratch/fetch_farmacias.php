<?php
$html = file_get_contents('http://www.ivss.gov.ve/contenido/Farmacias');
preg_match_all('/<a href="([^"]+)".*?>(Localizaci[^<]+)<\/a>/i', $html, $matches);

$results = [];

// also get "Farmacias de Alto Costo IVSS" link
if (preg_match('/<a href="([^"]+)".*?>(Farmacias de Alto Costo IVSS)<\/a>/i', $html, $m)) {
    array_unshift($matches[1], $m[1]);
    array_unshift($matches[2], $m[2]);
}

for ($i = 0; $i < count($matches[1]); $i++) {
    $url = $matches[1][$i];
    $title = trim($matches[2][$i]);
    if (strpos($url, 'http') === false) {
        $url = 'http://www.ivss.gov.ve/' . $url;
    }
    
    $page = @file_get_contents($url);
    if ($page) {
        // The content is usually inside an element with class "contenido" or just in a specific div
        // We will extract text.
        preg_match('/<div class="contenido"[^>]*>(.*?)<\/div>/is', $page, $contentMatch);
        if (isset($contentMatch[1])) {
            $text = strip_tags(str_replace(['<br>', '<br/>', '<br />', '</p>', '</div>'], "\n", $contentMatch[1]));
            // clean up extra lines
            $text = preg_replace("/[\r\n]+/", "\n", trim($text));
            $results[$title] = $text;
        } else {
             $results[$title] = "No content matched.";
        }
    }
}

file_put_contents('farmacias_data.json', json_encode($results, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
echo "Scraped " . count($results) . " pages.\n";
