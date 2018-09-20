<?php
session_cache_limiter("nocache");
session_start();
# configura��o do banco de dados
setlocale (LC_ALL, 'pt_BR.ISO8859-1');
define("RELDB", "mysql"); //mysql
define("DATABASE","pdo_ext");
define("HOST","localhost");
define("USER", "root");
define("PASSWORD", "");
define("OPTIONS", "");
# Uso de bufler
ob_start('ob_gzhandler');
# auto carregar classe a partir de quando ela � instanciada
function __autoload($classename)
{
include_once("class_".$classename.".php");
}

?>