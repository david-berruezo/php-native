<?php
/**
 * Creamos metodos
 * de añadidos
 * a la clase LoadUrls
 */
namespace clases;
class UrlsDiversual extends LoadUrls{
    private $ObjectDiversual    = "";
    /*
     * Consultas de los indices
     * de categorias,padres,hijos,nietos
     * e imagenes de los padres
     */
    public function setDiversual($ObjectDiversual){
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

    public function setPrueba($vectorContent){
        foreach($vectorContent as $content){
            echo "$content";
        }
    }
}
?>