<?
#include_once("../vendor/autoload.php");
include_once ("WordSeperators.php");
include_once("Crawler.php");
$c = new Crawler2("http://www.vinoseleccion.com/regiones/ribera-del-duero");
$links=$c->getAllLinks();

for ($r=0;$r<count($links);$r++)
	echo $links[$r]."<br>";
?>
<br>
############################################################
<br>
<?php echo $c->thelink; ?>