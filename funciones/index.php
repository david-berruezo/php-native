<?php
/*
 * Ejemplos 1
 * Tipo call_user_func
 */
$funcion = "pow";
print ("El cuadrado de 4 es: " .$funcion(4,2). "<br>");
echo ("El cubo de 4 es: " .$funcion(4,3). "<br>");

/*
 * Ejemplos 2
 * Tipo call_user_func
 * Desde dentro del objeto
 * y desde fuera del objeto
 */
class Prueba{
    private $metodo;
    public function __construct(){
        echo ("construir objeto<br>");
        $funcion = "decir";
        echo ("Llamamos al metodo ".$this->$funcion("David")."<br>");

    }
    public function poderLlamarAFuncion($funcion){
        $callback = $funcion;
        //make sure this stuff is valid
        if(!is_callable($callback, false, $callableName)) {
            throw new Exception("$callableName is not callable as a parameter to onspeak");
            return false;
        }
        $this->metodo = $callback;
    }
    public function llamarAFuncion(){
        if(isset($this->metodo)) {
            if(! call_user_func($this->metodo)) {
                return false;
            }
        }
    }
    public function decir($nombre){
        echo ("Método decir Hola " .$nombre. "<br>");
    }
    public function adios($nombre){
        echo ("Método decir adios " .$nombre. "<br>");
    }
    public function hablar(){
        echo ("Método hablar <br>");
    }
    public static function chillar(){
        echo ("Método chillar <br>");
    }
    public static function bienvenido($nombre){
        echo ("Método decir bienvenido otra vez con el corazón " .$nombre. "<br>");
    }
    public function llamadaFuera($funcion,$start,$end){
        call_user_func($funcion,$start,$end);
    }
}
$objeto  = new Prueba();
$funcion = "adios";
$objeto->$funcion("David");

/*
 * Ejemplo 3
 * Creamos una funcion
 * y la llamamos con call_user_function
 * luego llamamos a una función de un objeto con
 * parametros y sin parametros
 * OJO llamamos al nombre objeto, método y parámetro con static
 *
 */
function contar($start,$end){
    for($i=$start;$i<$end;$i++){
        echo ("El valor de empezar es " .$start. " y el de acabar es: " .$end. " y el valor actual i es ".$i. "<br>");
    }
}

function decrementar($start = 10, $end = 1){
    for($i=$start;$i>$end;$i--){
        echo ("El valor de empezar es " .$start. " y el de acabar es: " .$end. " y el valor actual i es ".$i. "<br>");
    }
}

call_user_func("contar",0,10);
call_user_func(array($objeto,"hablar"));
call_user_func(array($objeto,"adios"),"David");
call_user_func(array("Prueba","bienvenido"),"David");
call_user_func(array("Prueba","chillar"));

$objeto->llamadaFuera("contar",0,10);
$objeto->poderLlamarAFuncion("decrementar");
$objeto->llamarAFuncion();
?>