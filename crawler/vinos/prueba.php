<?php
/**
 * Created by PhpStorm.
 * User: David
 * Date: 25/08/2016
 * Time: 18:38
 */
$ch      = curl_init();
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_URL, 'http://localhost/php/php/crawler/vinos/detalle.html');
$content = curl_exec($ch);
curl_close($ch);
$document   = new DOMDocument();
@$document->loadHTML($content);
$xpath      = new DOMXpath($document);
// Paginas
$elementos  = $xpath->query("//*[contains(concat(' ', normalize-space(@class), ' '), ' reference ')]");
foreach($elementos as $elemento){
    echo "Referencia: ".$elemento->nodeValue."<br>";
}
//echo $content;
?>