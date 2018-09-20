<?php
/**
 * Created by PhpStorm.
 * User: David
 * Date: 03/06/2016
 * Time: 13:10
 */

Interface Abrible{
    public function open();
    public function close();
}

class ClaseBase implements Abrible{

    private $variableEncapsulada;
    public $variableAbierta;

    public function open(){
        echo('Abrir');
    }
    public function close(){
        echo('Cerrar');
    }
}