<?php
include_once "vendor/autoload.php";
use clases\LoadUrls;
use clases\Multicurl;
use clases\ObjectNemops;

error_reporting(0);

/*
 * Vector Inicial
 */
$vectorUrl        = array(0 => 'http://www.nemops.net/');
$nemopsObject     = new ObjectNemops();
//$vectorContent    = multiRequest($vectorUrl);

try {
    $mc = new LoadUrls();
    $mc->setMaxSessions(2); // limit 2 parallel sessions (by default 10)
    $mc->setMaxSize(10240); // limit 10 Kb per session (by default 10 Mb)
    foreach($vectorUrl as $url){
        $mc->addUrl($url);
    }
    $mc->wait();
} catch (Exception $e) {
    die($e->getMessage());
}


/*
 * Instanciamos nuestro objeto
 * y luego capturamos todas las
 * paginas
 */
$nemopsObject->setPagination($vectorContent);
$numeroPaginas = $nemopsObject->getPagination($vectorContent);
echo "numero paginas: ".$numeroPaginas."<br>";
$nemopsObject->setIndexContent($vectorContent);
$vectorUrl     = array();
for ($i = 0; $i < $numeroPaginas; $i++){
    if ($i === 0){
        $page = $i + 2;
        $url  = "http://www.nemops.net/page/".$page."/";
        array_push($vectorUrl,$url);
    }
}
$vectorContent = multiRequest($vectorUrl);
var_dump ($vectorContent);
$nemopsObject->setIndexContent($vectorContent);


/*
 * Peticionamos paginas
 */

function multiRequest($data) {
    $curly    = array();
    $result   = array();
    $mh       = curl_multi_init();
    $contador = 0;
    foreach ($data as $url) {
        $curly[$contador] = curl_init();
        curl_setopt($curly[$contador], CURLOPT_URL,            $url);
        curl_setopt($curly[$contador], CURLOPT_HEADER,         0);
        curl_setopt($curly[$contador], CURLOPT_RETURNTRANSFER, 1);
        curl_multi_add_handle($mh, $curly[$contador]);
        $contador++;
    }
    $contador = 0;
    $running  = null;
    do {
        curl_multi_exec($mh, $running);
    } while($running > 0);
    foreach($curly as $content){
        $result[$contador] = curl_multi_getcontent($content);
        curl_multi_remove_handle($mh, $content);
        $contador++;
    }
    curl_multi_close($mh);
    return $result;
}
?>