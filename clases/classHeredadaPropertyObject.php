<?php
/**
 * Created by PhpStorm.
 * User: David
 * Date: 24/06/2016
 * Time: 13:32
 */

require_once('class.PropertyObject.php');
class HeredadaPropertyObject extends PropertyObject{
    function __construct($addressid) {
        $this->propertyTable['nombre']   = 'David';
        $this->propertyTable['apellido'] = 'Berruezo';
        $this->propertyTable['emaail']   = 'davidberruezo@ecommercebarcelona';
    }
}
/*
$objetoHererdado = new HeredadaPropertyObject();
echo('El nombbre es: '.$objetoHererdado->getNombre().'<br>');
*/

