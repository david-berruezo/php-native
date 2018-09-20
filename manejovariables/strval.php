<?php
/**
 * Utilzando la función strval
 * lo que obtenemos es el método
 * toString de la clase
 * así que devolverá el nombre de la clase
 */

class Clase
{
    private $mistring = "Hola David";

    public function __toString()
    {
        return __CLASS__;
    }
    public function getMistring(){
        return strval($this->mistring);
    }
}

// Imprime 'StrValTest'
$objeto = new Clase;
echo strval($objeto) . "<br>" ;
echo strval($objeto->getMistring() . "<br>" );
