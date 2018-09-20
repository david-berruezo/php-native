<?php
/**
 * Creamos metodos
 * de añadidos
 * a la clase LoadUrls
 */
namespace clases;
class UrlsDiversual extends LoadUrls{
    private $Object    = "";

    public function setObject($Object){
        $this->Object = $Object;
    }

    public function setLeerUrls($vectorContent){
        $this->Object->leerUrls($vectorContent);
    }
}
?>