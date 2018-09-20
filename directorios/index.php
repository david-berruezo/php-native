<?php
/*
 * Definimos el directorio de trabajo
 */
// Primera opción
define('ABS_PATH', dirname($_SERVER['SCRIPT_FILENAME']) . '/');
echo "Esto es una prueba: ".dirname(__FILE__)."<br>";
echo ("El script esta en: ".$_SERVER['SCRIPT_FILENAME']."<br>\n");
echo ("El directorio del script esta en: :".dirname($_SERVER['SCRIPT_FILENAME'])."<br>\n");
echo "La constante ABS_PATH value " .ABS_PATH. "<br>\n";
echo("<br><br><br>");

/*
 * Segunda opción
 * Comentamos primero la Primera opción
 */
if( !defined('ABS_PATH') ) {
    define( 'ABS_PATH', dirname(__FILE__) . '/' );
}
echo ("El fichero vale: ".__FILE__."<br>\n");
echo ("El directorio del fichero vale: ".dirname(__FILE__)."<br>\n");
echo("<br><br><br>");

/*
 * Resumen __FILE ==  $_SERVER['SCRIPT_FILENAME']
 */
echo ("La función __FILE__ y \"$_SERVER[SCRIPT_FILENAME]\" son casi iguales excepto por las barras<br>");
echo ("El fichero vale: ".__FILE__."<br>\n");
echo ("El fichero vale: ".$_SERVER['SCRIPT_FILENAME']."<br>\n");

/*
 * Definimos una serie de contantes
 * que apuntan a los directorios siguientes
 */

define('LIB_PATH', ABS_PATH . 'oc-includes/');
define('CONTENT_PATH', ABS_PATH . 'oc-content/');
define('THEMES_PATH', CONTENT_PATH . 'themes/');
define('PLUGINS_PATH', CONTENT_PATH . 'plugins/');
define('TRANSLATIONS_PATH', CONTENT_PATH . 'languages/');
?>