<?php
/**
* Classe que retorna um 
* xml formatado ou não
* a partir de um SQL
* @author Marcelo Soares da Costa
* @email phpmafia at yahoo dot com dot br
* @copyright Marcelo Soares da Costa © 2007. 
* @license FreeBSD http://www.freebsd.org/copyright/freebsd-license.html
* @version 1,0
* @access public
* @package PDO_XML
* @subpackage PDO_EXT
* @data 2007-09-19
* @change : Old name class phpmafiasql2xml
*/ 
include_once ("class_pdo_extension.php");
################################################################################
class PDO_XML extends PDO_EXT
{
# Funcao que retorna html em um array
private function getxmlarray() 
{
   return $this->xmlarray;
} 
# Funcao que passa popula o array html
public function setxmlarray($string) 
{ 
	$this->xmlarray[] = $string; 
} 
#
public function printxmlarray($charset="iso-8859-1")
{
unset($this->printxml);
unset($this->xmlresult);
header("Content-type:application/xml; ".$charset);
$head = "<?xml version=\"1.0\" encoding=\"".$charset."\"?>\r";
foreach($this->getxmlarray()as $this->printxml)
   {
   $this->xmlresult.= $this->printxml."\r";
   }
   unset($this->xmlarray);
   print $head.$this->xmlresult;
}
#
private function xml2string($charset="iso-8859-1")
{
unset($this->printxml);
unset($this->xmlstring);
$this->xmlstring= "<?xml version=\"1.0\" encoding=\"".$charset."\"?>\r";
 foreach($this->getxmlarray() as $this->printxml)
 {
 $this->xmlstring.=$this->printxml;
 }
return $this->xmlstring;
}
# Funcao que concatena em uma string o array de parametros
private function array2htmlstring($array_param)
{
 $this->string=null;
 
 if($array_param!=null)
 {
  if(is_array($array_param))
   {
     foreach($array_param as $this->key=>$this->value)
     {
     $this->string.=$this->key."=\"".$this->value."\" ";
     }     
   }else{
   die("".$array_param." => Nao eh array");
   }
   return $this->string;
 }
}
#
public function simplexml($sqldataelement)
{
  
	//unset($this->xmlarray);
  $this->setsql($sqldataelement);
  $this->setxmlarray("<root>\r");
//	var_export($this->getassocarray());exit;
	  foreach($this->getassocarray() as $this->nrnode=>$this->datanode)
	  {  
     $this->data=$this->array2htmlstring($this->datanode);
     $this->setxmlarray("<row ".$this->data."/>\r");
     }

  $this->setxmlarray("</root>\r");

}
#
public function simpledomxml($rootelement,$dataelement,$sqldataelement)
{
$this->setsql($sqldataelement);
  
	  $this->setxmlarray("<".$rootelement.">\n");

	  foreach($this->getassocarray() as $this->nrnode=>$this->datanode)
	  {  
       $this->setxmlarray("<".$dataelement.">\n");
			//var_export($this->datanode);exit;
        foreach($this->datanode as $this->nodename=>$this->nodedata)
        {
        $this->setxmlarray("<".$this->nodename.">".$this->nodedata."</".$this->nodename.">\n");
        }
       $this->setxmlarray("</".$dataelement.">\n");
     }
// Fecha o Elemento root do XML
  $this->setxmlarray("</".$rootelement.">\n");
	//var_export($this->xmlarray);exit;
}

# Aplica um estilo ao xml do objeto
# Necesario as extensoes Dom, XMl e XSL do php5
public function xsltstyle($localxslt)
{
 if(phpversion()>=5)
 {
 $xmlstring=$this->xml2string();
 //echo $xmlstring;
 //die();
 $xml = new DomDocument();
 $xml->loadXML($xmlstring);
 $xsl = new DomDocument();
 $xsl->load($localxslt);
 $xslt = new XsltProcessor();
 $xslt->importStylesheet($xsl);

 $transformation = $xslt->transformToXml($xml);

//unset($this->xmlarray);
 print $transformation;
 }else{
 die("Para executar essa função é necesario php>=5");
 }
}
# Aplica o estilo a um xml por http
# Necesario as extensoes Dom, XMl e XSL do php5
public function xml4xls($urlxml,$localxslt)
{
 if(phpversion()>=5)
 {
 $xml = new DomDocument();
 $xml->load($xmluri);
 $xsl = new DomDocument();
 $xsl->load($localxslt);
 $xslt = new XsltProcessor();
 $xslt->importStylesheet($xsl);

 $transformation = $xslt->transformToXml($xml);

unset($this->xmlarray);

 print $transformation;
 }else{
 die("Para executar essa função é necesario php>=5");
 }
}

# fim da classe
}
?>