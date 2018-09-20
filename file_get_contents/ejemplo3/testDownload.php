<?php
include("EasyDownload.php");
// path example
//$myPath = "http://www.tiendanimal.es/especial-cria-ninfas-c-3_410.html";
$myPath = "../../";
// New Object
$objDownload = new EasyDownload();
// Set physical path
$objDownload->setPath($myPath);
// Set file name on the server (real full name)
echo ("El fichero es: " .$_GET["file"]. "<br>" );
$objDownload->setFileName($_GET["file"]);
// In case that it does not desire to effect download with original name.
// It configures the alternative name
$objDownload->setFileNameDown($_GET["fileName"] . $_GET["extension"]);
// get file
$objDownload->Send();
?>