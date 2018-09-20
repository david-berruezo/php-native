<?php
/**
 * Creamos metodos
 * de añadidos
 * a la clase LoadUrls
 */
namespace clases;
class UrlsFerreteria extends LoadUrls{
    private $ObjectFerreteria    = "";
    /*
     * Consultas de los indices
     * de categorias,padres,hijos,nietos
     * e imagenes de los padres
     */
    public function setFerreteria($Objectferreteria){
        $this->ObjectFerreteria = $Objectferreteria;
    }

    public function setIndexContent($vectorContent){
        $this->ObjectFerreteria->setIndexContent($vectorContent);
    }

    public function setPadreContent($vectorContent){
        $this->ObjectFerreteria->setPadreContent($vectorContent);
    }

    public function setHijoContent($vectorContent){
        $this->ObjectFerreteria->setHijoContent($vectorContent);
    }

    public function setNietoContent($vectorContent){
        $this->ObjectFerreteria->setNietoContent($vectorContent);
    }

    public function setProductoContent($vectorContent){
        $this->ObjectFerreteria->setProductoContent($vectorContent);
    }
}
?>