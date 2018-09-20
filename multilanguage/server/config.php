<?php
/*
 * Funcion para mostrar todos los lenguages 
 * que tenemos almacenados en nuestro
 * navegador 
 */
function prefered_language(array $available_languages, $http_accept_language) {
    $available_languages = array_flip($available_languages);
    $langs = [];
    preg_match_all('~([\w-]+)(?:[^,\d]+([\d.]+))?~', strtolower($http_accept_language), $matches, PREG_SET_ORDER);
    foreach($matches as $match) {
        list($a, $b) = explode('-', $match[1]) + array('', '');
        $value = isset($match[2]) ? (float) $match[2] : 1.0;
        if(isset($available_languages[$match[1]])) {
            $langs[$match[1]] = $value;
            continue;
        }
        if(isset($available_languages[$a])) {
            $langs[$a] = $value - 0.1;
        }
    }
    arsort($langs);
    return $langs;
}
$available_languages = array("en", "fr", "es-es");
$langs = prefered_language($available_languages, $_SERVER["HTTP_ACCEPT_LANGUAGE"]);
var_dump($langs);
// Coge el idioma por defecto del navegador
$lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
print_r($_SERVER['HTTP_ACCEPT_LANGUAGE']);
//echo "<br>";
//echo "EL lang es: ".$lang."<br>";
require_once($lang.".php");
?>