<?php
interface Concesionario{
    public function getName();
    public function addVehiculo(Vehiculo $vehiculo);
    public function getVehiculos();
    public function sellVehiculo(Vehiculo $vehiculo);
}
interface Vehiculo{
    public function getTipoVehiculo();
    public function assignToConcesionario(Concesionario $concesionario);
    public function getConcesionario();
    public function getNombre();
}
class ConcesionarioMartinez implements Concesionario{
    private $name;
    private $vehiculos = array();
    public function __construct($name){
        $this->name = $name;
    }
    public function getName(){
        return $this->name;
    }
    public function addVehiculo(Vehiculo $vehiculo){
        array_push($this->vehiculos,$vehiculo);
    }
    public function getVehiculos(){
        return $this->vehiculos;
    }
    public function sellVehiculo(Vehiculo $vehiculoSelled){
        foreach($this->getVehiculos() as $vehiculo){
            if ($vehiculoSelled == $vehiculo){
                echo('Registro encontrado:');
            }
        }
    }

}
class Coche implements Vehiculo{
    private $tipoVehiculo;
    private $nombre;
    private $concesionario;
    public function __construct($nombre,$tipoVehiculo)
    {
        $this->nombre = $nombre;
        $this->tipoVehiculo = $tipoVehiculo;
    }
    public function getTipoVehiculo(){
        return $this->tipoVehiculo;
    }
    public function assignToConcesionario(Concesionario $concesionario){
        $this->concesionario = $concesionario;
    }
    public function getNombre(){
        return $this->nombre;
    }
    public function getConcesionario(){
        return $this->concesionario;
    }
}

class Motocicleta implements Vehiculo{
    private $tipoVehiculo;
    private $nombre;
    private $concesionario;
    public function __construct($nombre,$tipoVehiculo)
    {
        $this->nombre = $nombre;
        $this->tipoVehiculo = $tipoVehiculo;
    }
    public function getTipoVehiculo(){
        return $this->tipoVehiculo;
    }
    public function assignToConcesionario(Concesionario $concesionario){
        $this->concesionario = $concesionario;
    }
    public function getConcesionario(){
        return $this->concesionario;
    }
    public function getNombre(){
        return $this->nombre;
    }
}

class Ciclomotor extends Motocicleta{
    public function __construct($nombre, $tipoVehiculo)
    {
        parent::__construct($nombre, $tipoVehiculo);
    }
}

/* *************** Llenamos Datos **************** */
$concesionarioMartinez = new ConcesionarioMartinez('Concesionario Martinez');
$coche                 = new Coche('Seat Ibiza 1600','Cohe');
$motocicleta           = new Motocicleta('Ducati Monster 750','Motocicleta');
$ciclomotor            = new Ciclomotor('Scoopy sh 50','Ciclomotor');

$concesionarioMartinez->addVehiculo($coche);
$concesionarioMartinez->addVehiculo($motocicleta);
$concesionarioMartinez->addVehiculo($ciclomotor);

foreach($concesionarioMartinez->getVehiculos() as $vehiculo){
    echo('Nombre: '.$vehiculo->getNombre().' Tipo: '.$vehiculo->getTipoVehiculo().'<br>');
}
?>
