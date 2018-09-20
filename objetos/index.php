<?php
/**
 * Created by PhpStorm.
 * User: David
 * Date: 22/08/2016
 * Time: 12:09
 */
class Foo {
    public function __construct() {
        echo "hola objeto";
        echo __CLASS__."<br>";
        echo get_called_class();
    }
}

class Bar extends Foo {
    public function __construct(ArrayObject $arrayObj, $number = 0) {
        /* do stuff with $arrayObj and $number */
    }
}

class Baz extends Bar {
    public function __construct(Bar $bar) {
        // yes, this is the proxy pattern
    }
}
$objeto = new Foo();
get_called_class();

// Copia de objeto
class Objeto{
    public $nombre;
    public $edat;
    public function __construct{
        echo "Hola";
    }
    public function setNombre($_nombre){$this->nombre = _nombre}
    public function getNombre(){return $this->nombre}
    public function setEdat($_edat){$this->edat = _edat}
    public function getEdat(){return $this->edat}
}
$mi_objeto = new Objeto();

?>