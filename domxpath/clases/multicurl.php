<?php
namespace clases;
class Multicurl{
    private $multicurl;
    private $vectorEntrada;
    private $vectorSalida;

    /*
     * Recibimos el vector
     * de la home y consultamos
     * para la home
     */
    public function __construct($vector)
    {
        $this->vectorEntrada   = array();
        $this->vectorSalida    = array();
        $this->vectorEntrada   = $vector;
        $this->multicurl       = curl_multi_init();
    }

    public function setContentAndOptions(){
        $contador = 0;
        foreach($this->vectorEntrada as $url){
            echo "url: ".$url."<br>";
            ${"ch{$contador}"} = curl_init();
            curl_setopt(${"ch{$contador}"}, CURLOPT_URL, $url);
            curl_setopt (${"ch{$contador}"}, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt(${"ch{$contador}"}, CURLOPT_FOLLOWLOCATION, FALSE);
            curl_setopt(${"ch{$contador}"},CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt(${"ch{$contador}"}, CURLOPT_FRESH_CONNECT, TRUE);
            curl_setopt(${"ch{$contador}"}, CURLOPT_FORBID_REUSE, TRUE);
            curl_setopt(${"ch{$contador}"}, CURLOPT_HEADER, FALSE);
            curl_setopt(${"ch{$contador}"}, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
            curl_multi_add_handle($this->multicurl,${"ch{$contador}"});
            //curl_setopt(${"ch{$contador}"}, CURLOPT_HEADER, 1);
            //curl_setopt(${"ch{$contador}"}, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
            //curl_setopt(${"ch{$contador}"}, CURLOPT_FOLLOWLOCATION, TRUE);
            //curl_setopt(${"ch{$contador}"},CURLOPT_SSL_VERIFYPEER, false);
            //curl_multi_setopt($this->multicurl,CURLMOPT_MAXCONNECTS,5000);
            //curl_multi_setopt($this->multicurl,CURLMOPT_PIPELINING,1);
            //curl_setopt(${"ch{$contador}"},CURLOPT_AUTOREFERER,true);
            //curl_setopt(${"ch{$contador}"}, CURLOPT_STREAM_WEIGHT, 256);
            //curl_setopt(${"ch{$contador}"}, CURLOPT_FRESH_CONNECT, TRUE);
            //curl_setopt(${"ch{$contador}"}, CURLOPT_PIPEWAIT, TRUE);
            //curl_setopt(${"ch{$contador}"}, CURLOPT_FORBID_REUSE, TRUE);
            //curl_setopt(${"ch{$contador}"}, CURLOPT_FORBID_REUSE, 1);
            //curl_setopt(${"ch{$contador}"}, CURLOPT_MAXCONNECTS, 5000);
            //curl_setopt(${"ch{$contador}"}, CURLOPT_NOBODY, 1);
            //curl_setopt(${"ch{$contador}"}, CURLOPT_MAXREDIRS, 5);
            //curl_setopt(${"ch{$contador}"},CURLMOPT_PIPELINING, 1);
            $contador++;
        }
        $contador = 0;
        $active   = null;
        do {
            //curl_multi_exec($this->multicurl, $running);
            $mrc = curl_multi_exec($this->multicurl, $active);
        } while($mrc == CURLM_CALL_MULTI_PERFORM);
        //} while ($running);
        while ($active && $mrc == CURLM_OK) {
            if (curl_multi_select($this->multicurl) != -1) {
                do {
                    $mrc = curl_multi_exec($this->multicurl, $active);
                } while ($mrc == CURLM_CALL_MULTI_PERFORM);
            }
        }
        /*
        foreach($this->vectorEntrada as $url){
            curl_multi_remove_handle($this->multicurl, ${"ch{$contador}"});
            echo curl_multi_getcontent(${"ch{$contador}"});
            //array_push($this->vectorSalida,curl_multi_getcontent(${"ch{$contador}"}));
            $contador++;
        }
        */
        //curl_multi_close($this->multicurl);
        curl_multi_close($this->multicurl);
        $contador = 0;
        //var_dump($this->vectorSalida);
    }

    /*
     * Recibimos vector
     * y consultamos para categorias
     */
    public function setCategorias($vector){
        $this->vectorEntrada   = array();
        $this->vectorSalida    = array();
        $this->multicurl       = curl_multi_init();
        $this->vectorEntrada   = $vector;
    }

    public function setOptionsCategorias($contadorCurl,$url){
        ${"ch{$contadorCurl}"} = curl_init();
        curl_setopt(${"ch{$contadorCurl}"}, CURLOPT_URL, $url);
        curl_setopt (${"ch{$contadorCurl}"}, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt(${"ch{$contadorCurl}"}, CURLOPT_FOLLOWLOCATION, FALSE);
        curl_setopt(${"ch{$contadorCurl}"},CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt(${"ch{$contadorCurl}"}, CURLOPT_FRESH_CONNECT, TRUE);
        curl_setopt(${"ch{$contadorCurl}"}, CURLOPT_FORBID_REUSE, TRUE);
        curl_setopt(${"ch{$contadorCurl}"}, CURLOPT_HEADER, FALSE);
        curl_setopt(${"ch{$contadorCurl}"}, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
        //curl_setopt(${"ch{$contadorCurl}"}, CURLOPT_MAXCONNECTS, 5000);
        //curl_multi_setopt($this->multicurl,CURLMOPT_MAXCONNECTS, 5000);
        curl_multi_add_handle($this->multicurl,${"ch{$contadorCurl}"});
        //curl_multi_setopt($this->multicurl,CURLMOPT_PIPELINING,1);
        //curl_setopt(${"ch{$contadorCurl}"}, CURLOPT_AUTOREFERER, true);
        //curl_setopt(${"ch{$contadorCurl}"}, CURLOPT_STREAM_WEIGHT, 256);
        //curl_setopt(${"ch{$contadorCurl}"}, CURLOPT_PIPEWAIT, TRUE);
        //curl_setopt(${"ch{$contadorCurl}"}, CURLOPT_NOBODY, 1);
        //curl_setopt(${"ch{$contador}"}, CURLOPT_MAXREDIRS, 5);
        //curl_setopt(${"ch{$contador}"},CURLMOPT_PIPELINING, 1);
        return ${"ch{$contadorCurl}"};
    }

    public function setContentCategorias(){
        echo "------------------ Cargamos MultiCurl ----------------<br>";
        $contadorUrls   = 0;
        foreach($this->vectorEntrada as $categorias){
            if (isset($categorias["hijos"])){
                foreach($categorias["hijos"] as $hijos){
                    if (isset($hijos["nietos"])){
                        foreach($hijos["nietos"] as $nietos){
                            echo "cargamos nieto url: ".$nietos["url"]."<br>";
                            ${"ch{$contadorUrls}"} = $this->setOptionsCategorias($contadorUrls,$nietos["url"]);
                            $contadorUrls++;
                        }
                    }
                    echo "cargamos hijo url: ".$hijos["url"]."<br>";
                    ${"ch{$contadorUrls}"} = $this->setOptionsCategorias($contadorUrls,$hijos["url"]);
                    $contadorUrls++;
                }
            }
            echo "cargamos padre url: ".$categorias["url"]."<br>";
            ${"ch{$contadorUrls}"} = $this->setOptionsCategorias($contadorUrls,$categorias["url"]);
            $contadorUrls++;
        }
        $contadorUrls   = 0;
        $contadorPadre  = 0;
        $contadorHijo   = 0;
        $contadorNieto  = 0;
        $active = null;
        do {
            //curl_multi_exec($this->multicurl, $running);
            $mrc = curl_multi_exec($this->multicurl, $active);
        //} while ($running);
        } while ($mrc == CURLM_CALL_MULTI_PERFORM);
        foreach($this->vectorEntrada as $categorias){
            if (isset($categorias["hijos"])){
                foreach($categorias["hijos"] as $hijos){
                    if (isset($hijos["nietos"])){
                        foreach($hijos["nietos"] as $nietos){
                            //var_dump( curl_multi_getcontent(${"ch{$contadorUrls}"}) );
                            //curl_multi_remove_handle($this->multicurl, ${"ch{$contadorUrls}"});
                            $this->vectorEntrada[$contadorPadre]["hijos"][$contadorHijo]["nietos"][$contadorNieto]["content"] = curl_multi_getcontent(${"ch{$contadorUrls}"});
                            //$this->vectorEntrada[$contadorPadre]["hijos"][$contadorHijo]["nietos"][$contadorNieto]["content"] = "contadorPadre: ".$contadorPadre." contadorHijo: ".$contadorHijo."contadorNieto: ".$contadorNieto;
                            $contadorNieto++;
                            $contadorUrls++;
                        }
                    }
                    //var_dump( curl_multi_getcontent(${"ch{$contadorUrls}"}) );
                    //curl_multi_remove_handle($this->multicurl, ${"ch{$contadorUrls}"});
                    $this->vectorEntrada[$contadorPadre]["hijos"][$contadorHijo]["content"] = curl_multi_getcontent(${"ch{$contadorUrls}"});
                    //$this->vectorEntrada[$contadorPadre]["hijos"][$contadorHijo]["content"] = "contadorPadre: ".$contadorPadre." contadorHijo: ".$contadorHijo;
                    $contadorUrls++;
                    $contadorHijo++;
                }
            }
            //var_dump( curl_multi_getcontent(${"ch{$contadorUrls}"}) );
            //curl_multi_remove_handle($this->multicurl, ${"ch{$contadorUrls}"});
            $this->vectorEntrada[$contadorPadre]["content"] = curl_multi_getcontent(${"ch{$contadorUrls}"});
            //$this->vectorEntrada[$contadorPadre]["content"] = "contadorPadre: ".$contadorPadre;
            $contadorUrls++;
            $contadorPadre++;
            $contadorHijo  = 0;
            $contadorNieto = 0;
        }
        $this->vectorSalida = $this->vectorEntrada;
        //var_dump($this->vectorSalida);
        curl_multi_close($this->multicurl);
        echo "------------------ Fin MultiCurl ----------------<br>";
    }


    /*
     * Cogemos todas las urls
     * de los detalles de los
     * productos
     */
     public function getDetailProduct(){
         echo "------------------ Cargamos Detalle MultiCurl ----------------<br>";
         $contadorUrls      = 0;
         $contadorHijo      = 0;
         $contadorNieto     = 0;
         $contadorPadre     = 0;
         $contadorProducto  = 0;
         foreach($this->vectorEntrada as $categorias){
             if (isset($categorias["hijos"])){
                 foreach($categorias["hijos"] as $hijos){
                     if (isset($hijos["nietos"])){
                         foreach($hijos["nietos"] as $nietos){
                             if (isset($nietos["productos"])){
                                 foreach($nietos["productos"] as $producto){
                                     echo "cargamos nieto hola url: ".$producto["url"]."<br>";
                                     ${"ch{$contadorUrls}"} = $this->setOptionsCategorias($contadorUrls,$producto["url"]);
                                     $contadorUrls++;
                                 }
                             }
                         }
                     }else{
                         if (isset($hijos["productos"])){
                             foreach($hijos["productos"] as $producto){
                                 echo "cargamos hijo hola url: ".$producto["url"]."<br>";
                                 ${"ch{$contadorUrls}"} = $this->setOptionsCategorias($contadorUrls,$producto["url"]);
                                 $contadorUrls++;
                             }
                         }
                     }
                 }
             }
         }
         $contadorUrls     = 0;
         do {
             curl_multi_exec($this->multicurl, $running);
         } while ($running);
         foreach($this->vectorEntrada as $categorias){
             if (isset($categorias["hijos"])){
                 foreach($categorias["hijos"] as $hijos){
                     if (isset($hijos["nietos"])){
                         foreach($hijos["nietos"] as $nietos){
                             foreach($nietos["productos"] as $producto){
                                 curl_multi_remove_handle($this->multicurl, ${"ch{$contadorUrls}"});
                                 $this->vectorEntrada[$contadorPadre]["hijos"][$contadorHijo]["nietos"][$contadorNieto]["productos"][$contadorProducto]["content"] = curl_multi_getcontent(${"ch{$contadorUrls}"});
                                 //$this->urls[$contadorPadre]["hijos"][$contadorHijo]["nietos"][$contadorNieto]["productos"] = $productos;
                                 //array_push($this->vectorEntrada[$contadorPadre]["hijos"][$contadorHijo]["nietos"][$contadorNieto]["content"],curl_multi_getcontent(${"ch{$contadorUrls}"}));
                                 $contadorProducto++;
                                 $contadorUrls++;
                             }
                             $contadorProducto = 0;
                             $contadorNieto++;
                         }
                     }else{
                         foreach($hijos["productos"] as $producto){
                             curl_multi_remove_handle($this->multicurl, ${"ch{$contadorUrls}"});
                             $this->vectorEntrada[$contadorPadre]["hijos"][$contadorHijo]["productos"][$contadorProducto]["content"] = curl_multi_getcontent(${"ch{$contadorUrls}"});
                             $contadorProducto++;
                             $contadorUrls++;
                         }
                         //array_push($this->vectorEntrada[$contadorPadre]["hijos"][$contadorHijo]["content"],curl_multi_getcontent(${"ch{$contadorUrls}"}));
                         $contadorProducto = 0;
                     }
                     $contadorHijo++;
                 }
             }
             $contadorPadre++;
         }
         $this->vectorSalida = $this->vectorEntrada;
         curl_multi_close($this->multicurl);
         echo "------------------ Fin MultiCurl ----------------<br>";
     }


    /*
     * Enviamos el vector
     * salida en el formato
     * que sea
     */
    public function getContent(){
        return $this->vectorSalida;
    }

}
?>