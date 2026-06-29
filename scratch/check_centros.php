<?php
$html = file_get_contents('c:/laragon/www/PaginaIVSS/scratch/centros_salud.html');
preg_match('/<div class="contenido"[^>]*>(.*?)<\/div>/is', $html, $contentMatch);
if (isset($contentMatch[1])) {
    echo strip_tags(str_replace(['<br>', '<br/>', '<br />', '</p>'], "\n", $contentMatch[1]));
} else {
    echo "No content found.";
}
