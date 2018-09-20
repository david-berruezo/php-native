<?php
/**
 * Created by PhpStorm.
 * User: David
 * Date: 06/06/2016
 * Time: 16:06
 */
$contadorCorreo             = 0;
$vectorCorreos              = array();
$vectorNombreClientesCorreo = array();
$contador                   = 0;
$contadorNavegador          = 0;
$inicio                     = FALSE;
interface Proveedor{
    public function addCorreo(Correo $correo);
    public function getCorreo(Correo $correo);
    public function getAllCorreo();
}
class Correo{
    private $subject;
    private $body;
    private $for;
    public function __construct($subject,$body,$for){
        global  $contadorCorreo;
        $this->body     = $body;
        $this->subject  = $subject;
        $this->for      = $for;
        $contadorCorreo++;
    }
    public function getSubject(){
        return $this->subject;
    }
    public function getBody(){
        return $this->body;
    }
    public function getFor(){
        return $this->for;
    }

}

class ProveedorCorreo implements Proveedor{
    protected $nombre;
    private $version;
    private $stmp;
    private $pop;
    private $correos;
    public function __construct($nombre,$version){
        $this->nombre  = $nombre;
        $this->version = $version;
        $this->correos = array();
    }
    public function addCorreo(Correo $correo){
        array_push($this->correos,$correo);
    }
    public function getCorreo(Correo $correoSelected){
        foreach($this->correos as $correo){
            if ($correo == $correoSelected){
                return ($correo);
            }
        }
    }
    public function getAllCorreo()
    {
        return $this->correos;
    }
    public function getNombre(){
        return $this->nombre;
    }
    public function getVersion(){
        return $this->version;
    }
    public function getSmtp(){
        return $this->smtp;
    }
    public function getPop(){
        return $this->pop;
    }
}

class ProveedorGoogle extends ProveedorCorreo{
    public function __construct($nombre,$version){
        parent::__construct($nombre,$version);
    }
    public function getNombre(){
        $this->nombre = 'Google';
        return $this->nombre;
    }

}

class ProveedorYahoo extends ProveedorCorreo{
    public function __construct($nombre,$version){
        parent::__construct($nombre,$version);
    }
    public function getNombre(){
        $this->nombre = 'Yahoo';
        return $this->nombre;
    }
}

class ProveedorOutlook extends ProveedorCorreo{
    public function __construct($nombre,$version){
        parent::__construct($nombre,$version);
    }
    public function getNombre(){
        $this->nombre = 'Outlook';
        return $this->nombre;
    }
}

// Inicializamo por herencia los 3 proveedores
$clienteGoogle   = new ProveedorGoogle('Google', '1.5');
$clienteYahoo    = new ProveedorYahoo('Google', '1.5');
$clienteOutlook  = new ProveedorYahoo('Google', '1.5');


// Creamos 3 correos
$correo1 = new Correo('Recordatorio Entreista','Recordar que el Lunes 6 tengo entrevista','mario.ortega@fhios.com');
$correo2 = new Correo('Recordatorio Lectura libro','Recordar que el Martes 7 lectura libro','davidberruezo@davidberruezo.com');
$correo3 = new Correo('Recordatorio ver Salvame','Belen Esteban Viernes 10 telecinco','davidberruezo@ecommercebarcelona360.com');


$clienteGoogle->addCorreo($correo1);
$clienteOutlook->addCorreo($correo2);
$clienteYahoo->addCorreo($correo3);

echo ('Sacamos correo Google<br>');
foreach($clienteGoogle->getAllCorreo() as $correo){
    echo('Subject: '.$correo->getSubject().' Body: '.$correo->getBody().' For: '.$correo->getFor().'<br>');
}

echo ('Sacamos correo Yahoo<br>');
foreach($clienteYahoo->getAllCorreo() as $correo){
    echo('Subject: '.$correo->getSubject().' Body: '.$correo->getBody().' For: '.$correo->getFor().'<br>');
}


echo ('Sacamos correo Outlook<br>');
foreach($clienteOutlook->getAllCorreo() as $correo){
    echo('Subject: '.$correo->getSubject().' Body: '.$correo->getBody().' For: '.$correo->getFor().'<br>');
}

/*
// Version igualando entre 3 para diferentes navegadores

$str = "One";
$class = "Class".$str;
$object = new $class();

// Guardamos los correos en un vector
array_push($vectorCorreos,$correo1);
array_push($vectorCorreos,$correo2);
array_push($vectorCorreos,$correo3);

// Guardamos los nombres de los clientes de correo en otro vector
array_push($vectorNombreClientesCorreo,'ProveedorGoogle');
array_push($vectorNombreClientesCorreo,'ProveedorYahoo');
array_push($vectorNombreClientesCorreo,'ProveedorOutlook');

foreach($vectorCorreos as $correo){
    if ($inicio == FALSE){
        $inicio == TRUE;
    }else{
        $comprobar = $contador % 3;
        if ($comprobar == 0){
            $contadorNavegador++;
        }
    }
    $contador++;
    $navegador = $vectorNombreClientesCorreo[$contadorNavegador];
    $objeto    = new $navegador($vectorNombreClientesCorreo[$contadorNavegador],'1.5');
    $objeto->addCorreo($correo);
}
*/





