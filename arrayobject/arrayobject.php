<?php
/**
 * Created by PhpStorm.
 * User: David
 * Date: 26/01/2016
 * Time: 9:17
 */

class Myarrayobject{

    protected $vector;

    public function __construct()
    {
        echo ('Construimos el objeto<br><br>');
    }

    public function llenarVector(){
        $this->vector = array(
             'name'  => 'David Berruezo',
             'email' => 'davidberruezo@ecommercebarcelona360.com'
        );
        var_dump($this->vector);
        echo('<br><br>');
        // create an instance of the ArrayObject class
        $arrayObj = new ArrayObject($this->vector, ArrayObject::ARRAY_AS_PROPS);
        var_dump($arrayObj);
        echo('<br><br>');
        foreach($arrayObj as $columna=>$valor){
            echo ('Columna: '.$columna.' Valor: '.$valor.'<br>');
        }
    }
}
$objetoArrayObject = new Myarrayobject();
$objetoArrayObject->llenarVector();