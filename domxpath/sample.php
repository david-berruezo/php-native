<?php
/**
 * Sample of Saxophone usage
 * @author Juraj Puchký - Devtech <sjurajpuchky@seznam.cz>
 * @license GPLv3
 * @version 1.0.8
 * @homepage http://www.devtech.cz
 * @copy (c) 2013 Juraj Puchký - Devtech
 * @description Simplest way to use parser which ever borned, you have to specify object params only then saxophone works for you.
 * Saxophone works with stream support and used about 1MB memory, simply fast as possible. With support of XHTML, XPATH.
 * 
 * @fix 1.0.1 Added support of XHTML, XPATH
 */

 include_once("Saxophone.php");
 
 function xprocess($record,$sax = null) {
     print_r($record);
 }
 
 function xprocesstag($name,$data,$attrs,$sax = null) {
     echo "Processed: $name:$data\n";
 }
 
 $GLOBALS["xmlopttag"] = array(
     "encoding" => "utf-8",
     "object" => "SHOPITEM",
     "type" => "TAG",
     "fields" => array(
         "productName" => "PRODUCT"
     ) 
 );
 
  $GLOBALS["xmloptxpath"] = array(
     "encoding" => "utf-8",
     "object" => "//*/SHOPITEM",
     "type" => "XPATH",
     "fields" => array(
         "productName" => "//*/SHOPITEM/PRODUCT"
     ) 
 );
         
         
 $fp = fopen("sax://xml;xprocess;xprocesstag;sample.xml;xmloptxpath","r",true);
 while(!feof($fp)) { fread($fp,4096);}
 fclose($fp);

 $fp1 = fopen("sax://xml;xprocess;xprocesstag;sample.xml;xmlopttag","r",true);
 while(!feof($fp1)) { fread($fp1,4096);}
 fclose($fp1);