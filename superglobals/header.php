<?php
namespace Proyecto\Superglobals;
/**
 * Created by PhpStorm.
 * User: David
 * Date: 29/07/2016
 * Time: 18:36
 */
class Prueba{
    public function __construct()
    {
        $GLOBALS["nombre"]   = "David";
        $GLOBALS["apellido"] = "Berruezo";
        echo ("Printeamos variables<br>\n");
        echo ("El nombre es: " .$GLOBALS["nombre"]. " y el apellido es: " .$GLOBALS["apellido"] . "<br>\n");
    }
    public function redireccion(){
        /* Redirecciona a una página diferente en el mismo directorio el cual se hizo la petición */
        $host  = $_SERVER['HTTP_HOST'];
        $uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
        $extra = 'pasarglobal.php';
        header("Location: http://$host$uri/$extra");
        exit;
        //header("location:pasarglobal.php");
    }
}
?>