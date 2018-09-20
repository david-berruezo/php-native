<?php
include_once ("class_pdo_xml.php");
################################################################################
# XML GRID
class PDO_GRID_XML extends  PDO_XML
{
/**
* Classe que retorna um grid a partir de xml
* @author Marcelo Soares da Costa
* @email phpmafia at yahoo dot com dot br
* @copyright Marcelo Soares da Costa © 2007. 
* @license FreeBSD http://www.freebsd.org/copyright/freebsd-license.html
* @version 0.4 beta
* @access public
* @package PDO_GRID_XML
* @subpackage PDO_EXT
* @data 2007-09-30
*/ 
public function encodeString($string)
{
  return base64_encode(serialize($string));
}
	
public function decodeString($string)
{
  return unserialize(base64_decode($string));
}

# 
private function __grid_xml()
{
	  $this->setxmlarray("<root>\n");
	  
	   if($this->title!=null)
	   {
	     $this->settitle();
	   }
	   
	   if(is_array($this->butonarray))
      {
		  $this->setbuton();
		}
		
		
		if(is_array($this->columarray))
      {
		  $this->sethead();
		}
		
		if($this->filter==true)
      {
		  $this->setfilter();
		}
		
		if($this->sqldata==true)
		{
			$this->__grid_data_xml($this->sqldata);
		}
		
		$this->setxmlarray("</root>\n");
}
# colocar array de campos para dar resultado no select
private function __grid_data_xml($sqldataelement)
{
$this->setsql($sqldataelement);
	  foreach($this->getassocarray() as $this->nrnode=>$this->datanode)
	  {  
       $this->setxmlarray("<data>\n");
		  $this->setxmlarray("<id>".$this->encodeString($this->datanode)."</id>\n");
		   $this->setxmlarray("<values>\n"); 
		
	       foreach(array_intersect_key($this->datanode,$this->columarray) as $this->nodename=>$this->nodedata)
          {         
           $this->setxmlarray("<".trim($this->nodename).">".trim($this->nodedata)."</".trim($this->nodename).">\n");
          }
        $this->setxmlarray("</values>\n");
       $this->setxmlarray("</data>\n");
      }
       
	//var_export($this->xmlarray);exit;
}
public function addcolum($key,$value) 
{ 
	$this->columarray[$key] = $value; 
} 

private function sethead()
{

  if(is_array($this->columarray))
  {
	$this->setxmlarray("<colum>\n");
    foreach($this->columarray as $colum)
    {
    $this->setxmlarray("<head>".trim($colum)."</head>\n");
    }
	$this->setxmlarray("</colum>\n");
  }
}
public function addbuton($key,$value) 
{ 
	$this->butonarray[$key] = $value; 
}
private function setbuton()
{

  if(is_array($this->butonarray))
  {
    foreach($this->butonarray as $key=>$value)
    {
    	$this->setxmlarray("<buton>\n");
		$this->setxmlarray("<bname>".trim($key)."</bname>\n");
		$this->setxmlarray("<burl>".trim($value)."</burl>\n");
		$this->setxmlarray("</buton>\n");
    }
  }
}
public function addfilter($key=null,$value=null) 
{ 
 if(($key!=null) AND ($value!=null))
  {
   $this->arrayfilters[$key] = $value;
  }	
 $this->filter=true;
}
private function setfilter()
{
// Opcoes de Filtros
if($this->arrayfilters==null)
{
$this->arrayfilters=array_flip($this->columarray);
}
  if(is_array($this->arrayfilters))
    {
	   foreach ($this->arrayfilters as $key=>$value)
		{
		$this->setxmlarray("<filters>\n");
		$this->setxmlarray("<filtername>".trim($key)."</filtername>\n");
		$this->setxmlarray("<filtervalue>".trim($value)."</filtervalue>\n");
		$this->setxmlarray("</filters>\n");
		}
    }
}	  
public function addtitle($string) 
{ 
	$this->title = $string; 
}
private function settitle() 
{ 
	$this->setxmlarray("<title>".trim($this->title)."</title>\n"); 
} 
public function addview($sql) 
{ 
	$this->sqldata = $sql; 
}
public function drawxml()
{
 $this->__grid_xml();
 $this->printxmlarray();  
}
public function drawGrid($xsl)
{
 $this->__grid_xml(); 
 $this->xsltstyle($xsl);
}
# fim da classe
}
?>