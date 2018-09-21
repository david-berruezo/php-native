<?php
namespace clases;
class Multicurl{
    // var
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
        $this->multicurl       = curl_multi_init();
        $this->vectorEntrada   = $vector;
    }
    public function setContentAndOptions(){
        $contador = 0;
        foreach($this->vectorEntrada as $url){
            ${"ch{$contador}"} = curl_init();
            curl_setopt(${"ch{$contador}"}, CURLOPT_URL, $url);
            curl_setopt(${"ch{$contador}"}, CURLOPT_HEADER, 0);
            //curl_setopt(${"ch{$contador}"}, CURLOPT_NOBODY, 1);
            curl_setopt(${"ch{$contador}"}, CURLOPT_STREAM_WEIGHT, 256);
            curl_setopt(${"ch{$contador}"}, CURLOPT_FRESH_CONNECT, TRUE);
            curl_setopt(${"ch{$contador}"}, CURLOPT_PIPEWAIT, TRUE);
            curl_setopt(${"ch{$contador}"}, CURLOPT_FORBID_REUSE, TRUE);
            //curl_setopt(${"ch{$contador}"}, CURLOPT_MAXREDIRS, 5);
            curl_setopt (${"ch{$contador}"}, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt(${"ch{$contador}"},CURLOPT_SSL_VERIFYPEER, false);
            //curl_setopt(${"ch{$contador}"},CURLMOPT_PIPELINING, 1);
            curl_setopt(${"ch{$contador}"}, CURLOPT_FORBID_REUSE, 1);
            curl_setopt(${"ch{$contador}"}, CURLOPT_MAXCONNECTS, 50);
            curl_multi_setopt($this->multicurl,CURLMOPT_MAXCONNECTS, 50);
            curl_multi_setopt($this->multicurl,CURLMOPT_PIPELINING,1);
            curl_multi_add_handle($this->multicurl,${"ch{$contador}"});
            $contador++;
        }
        $contador = 0;
        do {

            curl_multi_exec($this->multicurl, $running);
        } while ($running);
        foreach($this->vectorEntrada as $url){
            curl_multi_remove_handle($this->multicurl, ${"ch{$contador}"});
            array_push($this->vectorSalida,curl_multi_getcontent(${"ch{$contador}"}));
            $contador++;
        }
        curl_multi_close($this->multicurl);
        $contador = 0;
        var_dump($this->vectorSalida);
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
        curl_setopt(${"ch{$contadorCurl}"}, CURLOPT_HEADER, 0);
        curl_setopt(${"ch{$contadorCurl}"}, CURLOPT_STREAM_WEIGHT, 256);
        curl_setopt(${"ch{$contadorCurl}"}, CURLOPT_FRESH_CONNECT, TRUE);
        curl_setopt(${"ch{$contadorCurl}"}, CURLOPT_PIPEWAIT, TRUE);
        curl_setopt(${"ch{$contadorCurl}"}, CURLOPT_FORBID_REUSE, TRUE);
        curl_setopt (${"ch{$contadorCurl}"}, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt(${"ch{$contadorCurl}"},CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt(${"ch{$contadorCurl}"}, CURLOPT_FORBID_REUSE, 1);
        curl_setopt(${"ch{$contadorCurl}"}, CURLOPT_MAXCONNECTS, 50);
        curl_multi_setopt($this->multicurl,CURLMOPT_MAXCONNECTS, 50);
        curl_multi_setopt($this->multicurl,CURLMOPT_PIPELINING,1);
        //curl_setopt(${"ch{$contador}"}, CURLOPT_NOBODY, 1);
        //curl_setopt(${"ch{$contador}"}, CURLOPT_MAXREDIRS, 5);
        //curl_setopt(${"ch{$contador}"},CURLMOPT_PIPELINING, 1);
        curl_multi_add_handle($this->multicurl,${"ch{$contadorCurl}"});
        return ${"ch{$contadorCurl}"};
    }

    public function setContentCategorias(){
        $contadorUrls   = 0;
        foreach($this->vectorEntrada as $categorias){
            if (isset($categorias["hijos"])){
                foreach($categorias["hijos"] as $hijos){
                    if (isset($hijos["nietos"])){
                        foreach($hijos["nietos"] as $nietos){
                        }
                        ${"ch{$contadorUrls}"} = $this->setOptionsCategorias($contadorUrls,$hijos["url"]);
                    }
                $contadorUrls++;
                }
            }
            ${"ch{$contadorUrls}"} = $this->setOptionsCategorias($contadorUrls,$categorias["url"]);
            $contadorUrls++;
        }
        $contadorUrls   = 0;
        $contadorPadre  = 0;
        $contadorHijo   = 0;
        do {
            curl_multi_exec($this->multicurl, $running);
        } while ($running);
        foreach($this->vectorEntrada as $categorias){
            if (isset($categorias["hijos"])){
                foreach($categorias["hijos"] as $hijos){
                    if (isset($hijos["nietos"])){
                        foreach($hijos["nietos"] as $nietos){

                        }
                        curl_multi_remove_handle($this->multicurl, ${"ch{$contadorUrls}"});
                        array_push($this->vectorEntrada[$contadorPadre][$contadorHijo]["content"],curl_multi_getcontent(${"ch{$contadorUrls}"}));
                    }
                    $contadorUrls++;
                    $contadorHijo++;
                }
            }
            curl_multi_remove_handle($this->multicurl, ${"ch{$contadorUrls}"});
            array_push($this->vectorEntrada[$contadorPadre]["content"],curl_multi_getcontent(${"ch{$contadorUrls}"}));
            $contadorUrls++;
            $contadorPadre++;
        }
        $this->vectorSalida = $this->vectorEntrada;
        //var_dump($this->vectorEntrada);
        curl_multi_close($this->multicurl);
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