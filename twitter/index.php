<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 6/09/17
 * Time: 18:22
 */
include_once("vendor/autoload.php");
use clases\objetoTwitter;
$objetoTwitter = new ObjetoTwitter();
$twits = $objetoTwitter->getCincoTweets();
echo "<br><br>";
echo "---------------------- Contenido de los twits ------------------<br><br>";
$twits = json_decode($twits);
foreach($twits as $twit){
    echo "Contenido twit: ".$twit->text."<br><br><br>";
}
echo "---------------------- Fin Contenido ------------------<br><br>";
?>