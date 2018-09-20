<?php
/**
 * Creamos metodos
 * de añadidos
 * a la clase LoadUrls
 */
namespace clases;
class UrlsFerreteria extends LoadUrls{
    private $ObjectFerreteria    = "";
    private $contadorProductos   = 0;
    protected $_observers = array();

    /*
     * Consultas de los indices
     * de categorias,padres,hijos,nietos
     * e imagenes de los padres
     */
    /*
    public function setFerreteria($Objectferreteria){
        $this->ObjectFerreteria = $Objectferreteria;
    }
    */

    public function attachObserver($type, $observer)
    {
        $this->_observers[$type][] = $observer;
    }
    public function notifyObserver($type)
    {
        if (isset($this->_observers[$type])) {
            foreach ($this->_observers[$type] as $observer)
            {
                $observer->update($this);
            }
        }
    }

    public function finalizar()
    {
        //stub actions of buying
        //$this->notifyObserver("finalizar");
    }

    public function setIndexContent($vectorContent){
        //$this->ObjectFerreteria->setIndexContent($vectorContent);
        //Application::finalizarCarga("setIndexContent",$vectorContent);
        //$this->object->finalizarCarga("setIndexContent",$vectorContent);
        $this->notifyObserver("finalizar");
    }

    public function setPadreContent($vectorContent){
        //$this->ObjectFerreteria->setPadreContent($vectorContent);
        //Application::finalizarCarga("setPadreContent",$vectorContent);
    }

    public function setHijoContent($vectorContent){
        //$this->ObjectFerreteria->setHijoContent($vectorContent);
        //Application::finalizarCarga("setHijoContent",$vectorContent);
    }

    public function setNietoContent($vectorContent){
        //$this->ObjectFerreteria->setNietoContent($vectorContent);
        //Application::finalizarCarga("setNietoContent",$vectorContent);
    }

    /*
     * Consultas para productos
     * y contador de productos
     */
    public function setContadorProductos($contadorProductos){
        $this->contadorProductos = $contadorProductos;
    }

    public function setProductoContent($vectorContent){
        $this->ObjectFerreteria->setProductoContent($vectorContent,$this->contadorProductos);
        $this->contadorProductos++;
    }


}
?>