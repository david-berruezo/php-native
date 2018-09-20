<?php 
$mark1 = microtime();
//abre o arquivo de configuración (xml)
if(file_exists('_smvc/config.xml')) {$cfg=simplexml_load_file('_smvc/config.xml');}
else {exit('N�o achei o arquivo de configura��o!');}
//define o caminho se j� n�o estiver definido no arquivo de configura��o
if($cfg->path=="") {$cfg->path=dirname(__FILE__);}
if($cfg->uri=="") {@$cfg->uri=$_SERVER['REQUEST_URI'];}
//procura e carrega o CORE do sistema 
if(file_exists($cfg->core)) {include($cfg->core);}
else {exit("N�o achei o CORE do sistema!");}
?>