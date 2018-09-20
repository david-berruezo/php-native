<?php
/**
 * Created by PhpStorm.
 * User: David
 * Date: 29/01/2016
 * Time: 12:10
 */

class Prueba{

    private $id = 0;

    public function __construct()
    {
        echo ($this->id);
    }

}

$objeto = new Prueba();
