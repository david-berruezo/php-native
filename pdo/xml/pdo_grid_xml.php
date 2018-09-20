<?php
/*
CREATE TABLE `teste` (
  `id_teste` int(11) NOT NULL auto_increment,
  `name1` varchar(128) NOT NULL,
  `name2` varchar(128) NOT NULL,
  `name3` varchar(128) NOT NULL,
  PRIMARY KEY  (`id_teste`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1
*/
include_once ("_autoload.php");

if($_REQUEST["filter"]!=null)
{
$WHERE=" WHERE ".$_REQUEST["filter"]." LIKE '".$_REQUEST["filtervalue"]."%'";
}else{
$WHERE=null;
}

$SQL="SELECT * FROM teste ".$WHERE;


$teste = new pdo_grid_xml;
$teste->addtitle("Teste de Grid XML/XSL");

$teste->addbuton("novo","add.php");
$teste->addbuton("editar","edit.php");

$teste->addcolum("name1","Colum1");
$teste->addcolum("name2","Colum2");
$teste->addcolum("name3","Colum3");

$teste->addfilter();

$teste->addview($SQL);

//$teste->drawxml();

//$teste->drawGrid("__grid.xsl");
$teste->drawGrid("__grid_button.xsl");