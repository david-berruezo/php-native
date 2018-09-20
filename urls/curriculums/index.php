<?php
include_once("vendor/autoload.php");
// Application
use clases\Objectpublidata;
use clases\Publidata;
use clases\MultiCurl;
use clases\LoadUrls;

/*
 * Errores
 */
// ini_set('display_errors', 1);
// error_reporting( E_ALL );

ini_set('display_errors', 0);
error_reporting( E_ERROR );

/*
 * Cargamos objetos
 */
$loadUrls        = new LoadUrls();
$objetoPublidata = new ObjectPublidata();
$application     = new Application($objetoPublidata);


class Application {
    // Publidata object
    private $objetoPublidata;
    private $categorias = array(
        "0"   => "Todas",
        "275" => "Abogados especializados en publicidad",
        "202" => "Agencias de comunicación integrada",
        "208" => "Agencias de eventos",
        "204" => "Agencias de marketing directo / relacional",
        "205" => "Agencias de marketing promocional",
        "203" => "Agencias de medios",
        "255" => "Agencias de modelos, artistas y casting",
        "207" => "Agencias de patrocinio",
        "201" => "Agencias de publicidad",
        "209" => "Agencias de RRPP",
        "206" => "Agencias interactivas",
        "213" => "Anunciantes",
        "265" => "Asociaciones",
        "256" => "Bancos de imágenes",
        "232" => "Bases de datos",
        "230" => "Cine",
        "234" => "Consultoras de internet",
        "233" => "Consultoras de marketing y comunicación",
        "242" => "Derechos y licencias",
        "227" => "Diarios",
        "257" => "Diseño",
        "217" => "Exclusivas",
        "276" => "Festivales Publicitarios",
        "274" => "Formación en publicidad y marketing",
        "258" => "Fotografía",
        "248" => "Fotomecánicas",
        "229" => "Guías, directorios y anuarios",
        "249" => "Imprentas",
        "250" => "Impresión digital",
        "246" => "Informática sector publicitario",
        "244" => "Institutos",
        "245" => "Investigación de medios",
        "259" => "Laboratorios fotográficos",
        "239" => "Marketing móvil",
        "238" => "Marketing on line",
        "236" => "Marketing telefónico",
        "225" => "Medios on line",
        "220" => "Mobiliario urbano",
        "251" => "Papeleras",
        "260" => "Postproducción",
        "254" => "Producción de eventos",
        "263" => "Producción multimedia",
        "262" => "Producción sonido",
        "261" => "Productoras",
        "241" => "Proveedores de internet",
        "264" => "Proveedores de producción",
        "222" => "Publicidad aérea",
        "235" => "Publicidad directa",
        "215" => "Radio",
        "228" => "Revistas",
        "221" => "Rótulos luminosos",
        "252" => "Serigrafías",
        "237" => "Servicios de comercio electrónico",
        "277" => "Servicios de neuromarketing",
        "240" => "Servicios y material promocional",
        "224" => "Soportes varios",
        "226" => "Suplementos",
        "216" => "Televisión",
        "223" => "Transporte / Publicidad exterior móvil",
        "219" => "Vallas carteleras",
    );
    // Categorias realizadas
    // 'act'         => '238',
    // 'act'         => '208',
    // 'act'         => '205',
    // 'act'         => '203',
    // 'act'         => '255',
    // 'act'         => '207',
    // "201" => "Agencias de publicidad",
    // "209" => "Agencias de RRPP",
    // 206 => "Agencias de RRPP",
    // "213" => "Anunciantes",
    // "265" => "Asociaciones",
    // "256" => "Bancos de imágenes",
    // "232" => "Bases de datos",
    // "230" => "Cine",
    // "234" => "Consultoras de internet",
    // "233" => "Consultoras de marketing y comunicación",
    // "242" => "Derechos y licencias",
    // "227" => "Diarios",
    // "257" => "Diseño",
    // "217" => "Exclusivas",
    // "276" => "Festivales Publicitarios",
    // "274" => "Formación en publicidad y marketing",
    // "258" => "Fotografía",
    // "248" => "Fotomecánicas",
    // "229" => "Guías, directorios y anuarios",
    // "249" => "Imprentas",
    // "250" => "Impresión digital",
    // "246" => "Informática sector publicitario",
    // "244" => "Institutos",
    // "245" => "Investigación de medios",
    // "259" => "Laboratorios fotográficos",
    // "239" => "Marketing móvil",
    // "238" => "Marketing on line",
    // "236" => "Marketing telefónico",
    // "225" => "Medios on line",
    // "220" => "Mobiliario urbano",
    // "251" => "Papeleras",
    // "260" => "Postproducción",
    // "254" => "Producción de eventos",
    // "263" => "Producción multimedia",
    // "262" => "Producción sonido",
    // "261" => "Productoras",
    // "241" => "Proveedores de internet",
    // "264" => "Proveedores de producción",
    // "241" => "Proveedores de internet",
    // "264" => "Proveedores de producción",
    // "222" => "Publicidad aérea",
    // "235" => "Publicidad directa",
    // "215" => "Radio",
    // POSTFIELDS cURL parametters
    // "228" => "Revistas",
    // "221" => "Rótulos luminosos",
    // "252" => "Serigrafías",
    // "237" => "Servicios de comercio electrónico",
    // "277" => "Servicios de neuromarketing",
    // "240" => "Servicios y material promocional",
    // "224" => "Soportes varios",
    // "226" => "Suplementos",
    // "216" => "Televisión",
    // "223" => "Transporte / Publicidad exterior móvil",
    // "219" => "Vallas carteleras",
    private $post = [
                'RealQuery'   => '',
                'CurrentPage' => '',
                'Exclude'     => '',
                'query'       => 'Buscar empresa de marketing o medio',
                'prov'        => 'Barcelona',
                'act'         => '219',
                'searchaBtn'  => 'BUSCAR',
    ];
    // Header cURL parametters
    private $header = array(
        "Accept: */*",
        "Cache-Control: max-age=0",
        "Accept-Charset: utf-8;q=0.7,*;q=0.7",
        "Accept-Language: en-us,en;q=0.5",
        "Pragma: ",
    );


    /*
     * Cargamos el index
     */
    public function __construct($objetoPublidata)
    {
        $this->objetoPublidata = $objetoPublidata;

        try {
            $loadUrls = new LoadUrls();
            $loadUrls->setFuncion("setIndexContent");
            $loadUrls->setApplicationObject($this);
            $loadUrls->setMaxSessions(2); // limit 2 parallel sessions (by default 10)
            $loadUrls->setMaxSize(10240); // limit 10 Kb per session (by default 10 Mb)
            $loadUrls->setTotal(1);

            $curlOptions=array(
                CURLOPT_HEADER     		=> true,
                CURLOPT_HTTPHEADER 		=> $this->header,
                CURLOPT_USERAGENT  		=> 'Googlebot/2.1 (+http://www.google.com/bot.html)',
                CURLOPT_CONNECTTIMEOUT 	=> 20,
                CURLOPT_TIMEOUT 		=> 10,
                CURLOPT_POSTFIELDS      => $this->post
            );

            $loadUrls->setCurlOptions($curlOptions);
            $loadUrls->addUrl('http://www.publidata.es/buscar-empresa-marketing-medios');
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
        $this->objetoPublidata->setIndexContent($contentVector);
        $this->getAllPages();
    }



    /*
     * Bucle all pages
     */
     private function getAllPages(){
        $npages = $this->objetoPublidata->getPages();
        for($i=1;$i<=$npages;$i++){
            try {
                $loadUrls = new LoadUrls();
                $loadUrls->setFuncion("setPages");
                $loadUrls->setApplicationObject($this);
                $loadUrls->setMaxSessions(2); // limit 2 parallel sessions (by default 10)
                $loadUrls->setMaxSize(10240); // limit 10 Kb per session (by default 10 Mb)
                $loadUrls->setTotal(1);
                $this->post['CurrentPage'] = $i;
                $curlOptions=array(
                    CURLOPT_HEADER     		=> true,
                    CURLOPT_HTTPHEADER 		=> $this->header,
                    CURLOPT_USERAGENT  		=> 'Googlebot/2.1 (+http://www.google.com/bot.html)',
                    CURLOPT_CONNECTTIMEOUT 	=> 20,
                    CURLOPT_TIMEOUT 		=> 10,
                    CURLOPT_POSTFIELDS      => $this->post
                );
                $loadUrls->setCurlOptions($curlOptions);
                $loadUrls->addUrl('http://www.publidata.es/buscar-empresa-marketing-medios');
                $loadUrls->wait();

            } catch (Exception $e) {
                die($e->getMessage());
            }
        }
        $this->get_detalle();
     }


    /*
     * Set pages
     */
    public function setPages($contentVector){
        $this->objetoPublidata->setAllContent($contentVector);
    }


    /*
     * Get Detalle
     */
    private function get_detalle(){
        $urls = $this->objetoPublidata->get_urls_detalle();
        $contador = 0;
        foreach($urls as $url){
            //if ($contador < 2){
                try {
                    $loadUrls = new LoadUrls();
                    $loadUrls->setFuncion("set_detalle");
                    $loadUrls->setApplicationObject($this);
                    $loadUrls->setMaxSessions(2); // limit 2 parallel sessions (by default 10)
                    $loadUrls->setMaxSize(10240); // limit 10 Kb per session (by default 10 Mb)
                    $loadUrls->setTotal(1);
                    $curlOptions=array(
                        CURLOPT_HEADER     		=> true,
                        CURLOPT_HTTPHEADER 		=> $this->header,
                        CURLOPT_USERAGENT  		=> 'Googlebot/2.1 (+http://www.google.com/bot.html)',
                        CURLOPT_CONNECTTIMEOUT 	=> 20,
                        CURLOPT_TIMEOUT 		=> 10,
                    );
                    $loadUrls->addUrl($url);
                    $loadUrls->wait();
                } catch (Exception $e) {
                    die($e->getMessage());
                }
                $contador++;
            //}
        }
        $this->objetoPublidata->send_email();
    }


    /*
     * Set Detalle
     */
    public function set_detalle($contentVector){
        $this->objetoPublidata->setDetalleContent($contentVector);
    }
}
?>