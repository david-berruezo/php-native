<?php
require_once "../vendor/autoload.php";
use Sunra\PhpSimple\HtmlDomParser;
class Prueba extends Crawler{

    private $url = 'http://www.vinoseleccion.com/regiones/ribera-del-duero';

    public function __construct()
    {
        parent::__construct();
    }
    public function setUrl($url){
        $this->url = $url;
        //$this->setContent($this->url);
    }
    public function getUrl(){
        return $this->url;
    }
    public function printGetElementsByClassName($classname){
           $registros = $this->getElementsByClassName($this->url,"product-name");
           var_dump($registros);
    }
    public function printGetElementsByTagName($tagname){
        $registros = $this->getElementsByTagName($this->url,$tagname);
        var_dump($registros);
    }
    public function printEvaluateTag($tagname){
        $registros = $this->evaluateTag($this->url,$tagname);
        var_dump($registros);
    }
    public function printImages(){
        $image     = $this->crawlImage($this->url);
        echo "<table width=\"100%\" border=\"1\">
          <tr>
            <td width=\"30%\"><div align=\"center\"><b>Image</b></div></td>
            <td width=\"30%\"><div align=\"center\"><b>Link</b></div></td>
            <td width=\"40%\"><div align=\"center\"><b>Image Link</b> </div></td>
          </tr>";
                for($i=5;$i<sizeof($image['link'])-7;$i++)
                {
                    echo "<tr>
            <td><div align=\"center\"><img src=\"".$image['src'][$i]."\"/></div></td>";
                    if(($image['link'][$i])==null)
                    {
                        echo "<td width=\"30%\"><div align=\"center\">No Link</div></td>
            <td width=\"40%\"><div align=\"center\">No Link</div></td>
          </tr>";
                    }
                    else
                    {
                        echo "<td><div align=\"center\">".$image['link'][$i]."</div></td>
            <td><div align=\"center\"><a href=\"".$image['link'][$i]."\">Go to link.</a></div></td>
            </tr>";
            }
        }
        echo "</table>";
    }
}

// Url primera
// http://www.vinoseleccion.com/regiones/ribera-del-duero
$vino = new Prueba();
$vino->setUrl('http://www.vinoseleccion.com/regiones/ribera-del-duero');
$vino->printImages();
$vino->printGetElementsByTagName();

/*
$vino->printGetElementsByClassName("product-name");
$vino->printGetElementsByTagName("h2");
$vino->printEvaluateTag("a");
*/

/*
if (!function_exists('curl_init')){
    die('Sorry cURL is not installed!');
}else{
    $url = "http://www.vinoseleccion.com/regiones/ribera-del-duero";
    $ch  = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    $output = curl_exec($ch);
    echo gettype($output);
    curl_close($ch);
    echo ($output);
}
*/
?>