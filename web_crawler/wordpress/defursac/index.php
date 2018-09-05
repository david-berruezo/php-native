<?php
include_once("vendor/autoload.php");
use clases\ObjetoTrajes;
use clases\ObjectWpbeginner;
use clases\MultiCurl;
use clases\LoadUrls;

/*
 * Errores
 */
//ini_set('display_errors', 1);
//error_reporting( E_ALL );


/*
 * Cargamos objetos
 */
$loadUrls     = new LoadUrls();
$objetoTrajes = new ObjetoTrajes();
$application  = new Application($objetoTrajes);

class Application {
    private $objetoTrajes;
    /*
     * Cargamos el index
     */
    public function __construct($objetoTrajes)
    {
        $this->objetoTrajes = $objetoTrajes;
        try {
            $loadUrls = new LoadUrls();
            $loadUrls->setFuncion("setIndexContent");
            $loadUrls->setApplicationObject($this);
            $loadUrls->setMaxSessions(2); // limit 2 parallel sessions (by default 10)
            $loadUrls->setMaxSize(10240); // limit 10 Kb per session (by default 10 Mb)
            $loadUrls->setTotal(1);
            $loadUrls->addUrl('http://www.defursac.net/en/mens-looks.html');
            //$loadUrls->addUrl('https://makeyoursuit-outlet-website-dev.wellbehavedsoftware.com/utils/www.defursac.fr/en/mens-looks.html');
            $loadUrls->wait();
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    /*
     * Guardamos el index de las
     * categorias
     */
    public function setIndexContent($contentVector){
        $this->objetoTrajes->setIndexContent($contentVector);
        $this->getProducts();
    }

    /*
     * get products
     */
    public function getProducts(){
        $categorias = $this->objetoTrajes->getCategories();
        var_dump($categorias);
        try {
            $loadUrls = new LoadUrls();
            $loadUrls->setFuncion("setProducts");
            $loadUrls->setApplicationObject($this);
            $loadUrls->setMaxSessions(2); // limit 2 parallel sessions (by default 10)
            $loadUrls->setMaxSize(10240); // limit 10 Kb per session (by default 10 Mb)
            $loadUrls->setTotal(count($categorias));
            foreach($categorias as $categoria){
                $loadUrls->addUrl($categoria);
            }
            $loadUrls->wait();
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    /*
     * set products
     */
     public function setProducts($contentVector){
         $this->objetoTrajes->setProductContent($contentVector);
         $this->getDetailProducts();
     }

     /*
      * Get detail content
      */
    public function getDetailProducts(){
        $productos = $this->objetoTrajes->getProductContent();
        try {
            $loadUrls = new LoadUrls();
            $loadUrls->setFuncion("setDetailProducts");
            $loadUrls->setApplicationObject($this);
            $loadUrls->setMaxSessions(2); // limit 2 parallel sessions (by default 10)
            $loadUrls->setMaxSize(10240); // limit 10 Kb per session (by default 10 Mb)
            $loadUrls->setTotal(count($productos["url"]));
            foreach($productos["url"] as $producto){
                //echo "producto: ".$producto."<br>";
                $loadUrls->addUrl($producto);
            }
            $loadUrls->wait();
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    /*
     * set products
     */
    public function setDetailProducts($contentVector){
        $this->objetoTrajes->setProductDetailContent($contentVector);
    }
}
?>