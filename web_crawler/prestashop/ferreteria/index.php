<?php
include_once "vendor/autoload.php";
use clases\LoadUrls;
use clases\ObjectFerreteria;
use clases\MultiCurl;

/*
 * Errores
 */
//ini_set('display_errors', 'On');
error_reporting(E_ERROR);
// | E_WARNING | E_PARSE
//ini_set('display_errors', '1');

/*
 * Cargamos objetos
 */
$loadUrls         = new LoadUrls();
$objetoFerreteria = new ObjectFerreteria();
$application      = new Application($objetoFerreteria);

class Application {
    private $objetoFerreteria;
    private $vectorProductosUrl;
    private $parteEntera;
    private $parteDecimal;
    private $resto;
    private $contadorVeces1000Productos;

    /*
     * Cargamos el index
     */
    public function __construct($objetoFerreteria)
    {
        $this->objetoFerreteria = $objetoFerreteria;
        try {
            $loadUrls = new LoadUrls();
            $loadUrls->setFuncion("setIndexContent");
            $loadUrls->setApplicationObject($this);
            $loadUrls->setMaxSessions(2); // limit 2 parallel sessions (by default 10)
            $loadUrls->setMaxSize(10240); // limit 10 Kb per session (by default 10 Mb)
            $loadUrls->addUrl('http://www.ferreteria.net/');
            $loadUrls->wait();
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    /*
     * Cargamos el index content
     */
    public function setIndexContent($vectorContent){
        $this->objetoFerreteria->setIndexContent($vectorContent);
        $this->getPadresContent();
    }

    /*
     * Ahora cogemos todos los
     * datos del vector Padre
     */
     public function getPadresContent(){
         $vectorUrlsPadres = $this->objetoFerreteria->getPadres();
         try {
             $loadUrls = new LoadUrls();
             $loadUrls->setFuncion("setPadresContent");
             $loadUrls->setApplicationObject($this);
             $loadUrls->setMaxSessions(2); // limit 2 parallel sessions (by default 10)
             $loadUrls->setMaxSize(10240); // limit 10 Kb per session (by default 10 Mb)
             $loadUrls->setTotal(count($vectorUrlsPadres));
             foreach($vectorUrlsPadres as $padres){
                 $loadUrls->addUrl($padres);
             }
            $loadUrls->wait();
         } catch (Exception $e) {
             die($e->getMessage());
         }
     }

     /*
      * Gurardamos padres content
      * en objeto ferreteria
      */
      public function setPadresContent($vectorContent){
          $this->objetoFerreteria->setPadreContent($vectorContent);
          $this->getHijos();
      }

     /*
      * Ahora cogemos todos los hijos
      */
      public function getHijos(){
          $vectorUrlsHijos = $this->objetoFerreteria->getHijos();
          try {
              $loadUrls = new LoadUrls();
              $loadUrls->setFuncion("setHijosContent");
              $loadUrls->setApplicationObject($this);
              $loadUrls->setMaxSessions(2); // limit 2 parallel sessions (by default 10)
              $loadUrls->setMaxSize(10240); // limit 10 Kb per session (by default 10 Mb)
              $loadUrls->setTotal(count($vectorUrlsHijos));
              foreach($vectorUrlsHijos as $padres){
                  $loadUrls->addUrl($padres);
              }
              $loadUrls->wait();
          } catch (Exception $e) {
              die($e->getMessage());
          }
      }

      /*
       * Colocamos hijos content
       * en objeto ferreteria
       */
       public function setHijosContent($vectorContent){
           $this->objetoFerreteria->setHijoContent($vectorContent);
           $this->getNietos();
       }

       /*
        * Obtenemos los nietos
        */
        public function getNietos(){
            $vectorUrlsNietos = $this->objetoFerreteria->getNietos();
            $contador = 0;
            try {
                $loadUrls = new LoadUrls();
                $loadUrls->setFuncion("setNietosContent");
                $loadUrls->setApplicationObject($this);
                $loadUrls->setMaxSessions(2); // limit 2 parallel sessions (by default 10)
                $loadUrls->setMaxSize(10240); // limit 10 Kb per session (by default 10 Mb)
                $loadUrls->setTotal(643);
                foreach($vectorUrlsNietos as $padres){
                    if ($contador < 644){
                        $loadUrls->addUrl($padres);
                    }
                    $contador++;
                }
                $loadUrls->wait();
            } catch (Exception $e) {
                die($e->getMessage());
            }
        }

        /*
         * Colocamos nietos
         * content
         */
         public function setNietosContent($vectorContent){
             $this->objetoFerreteria->setNietoContent($vectorContent);
             $this->vectorProductosUrl = $this->objetoFerreteria->getProductosUrl();
             $this->calcularProductos();
             //$this->objetoFerreteria->printCategoriaPrincipal();
             var_dump($this->vectorProductosUrl);
         }

         /*
          * Calculamos la divisón de los
          * productos de 1000 en 1000 para
          * las cargas de las urls
          */
         public function calcularProductos(){
             $numero             = count($this->vectorProductosUrl);
             $divisor            = $numero / 1000;
             $dec                = $this->getParteEnteraParteDecimal($divisor,false);
             $this->resto        = $dec[1] * 1000;
             $this->parteEntera  = $dec[0];
             $this->parteDecimal = $dec[1];
             $this->getProductos();
         }

        /*
         * Obtenemos los productos
         */
        public function getProductos(){
            $contador = 0;
            if ($this->contadorVeces1000Productos < $this->parteEntera){
                try {
                    $loadUrls = new LoadUrls();
                    $loadUrls->setFuncion("getProductos");
                    $loadUrls->setApplicationObject($this);
                    $loadUrls->setMaxSessions(2); // limit 2 parallel sessions (by default 10)
                    $loadUrls->setMaxSize(10240); // limit 10 Kb per session (by default 10 Mb)
                    $loadUrls->setTotal(1000);
                    foreach($this->vectorProductosUrl as $producto){
                        if ($contador <= ($this->contadorVeces1000Productos+1) * 1000 && $contador >= $this->contadorVeces1000Productos * 1000){
                            $loadUrls->addUrl($producto);
                            echo ("contador: ".$contador." parte entera: ".$producto."<br>");
                        }
                        $contador++;
                    }
                    $loadUrls->wait();
                    $this->contadorVeces1000Productos++;
                } catch (Exception $e) {
                    die($e->getMessage());
                }
            }else{
                $inicio = count($this->vectorProductosUrl) - $this->resto;
                try {
                    $loadUrls = new LoadUrls();
                    $loadUrls->setFuncion("getProductos");
                    $loadUrls->setApplicationObject($this);
                    $loadUrls->setMaxSessions(2); // limit 2 parallel sessions (by default 10)
                    $loadUrls->setMaxSize(10240); // limit 10 Kb per session (by default 10 Mb)
                    $loadUrls->setTotal($this->resto);
                    foreach($this->vectorProductosUrl as $producto){
                        if ($contador >= $inicio){
                            $loadUrls->addUrl($producto);
                            echo ("contador: ".$contador." parte decimal: ".$producto."<br>");
                        }
                        $contador++;
                    }
                    $loadUrls->wait();
                    $this->contadorVeces1000Productos++;
                } catch (Exception $e) {
                    die($e->getMessage());
                }
            }
        }

        /*
         * Obtenemos la parte
         * decimal y la parte natural
         * de un número
         */
        private function getParteEnteraParteDecimal($number, $returnUnsigned = false){
            $negative = 1;
            if ($number < 0)
            {
                $negative = -1;
                $number *= -1;
            }
            if ($returnUnsigned){
                return array(
                    floor($number),
                    ($number - floor($number))
                );
            }
            return array(
                floor($number) * $negative,
                ($number - floor($number)) * $negative
            );
        }
}
?>