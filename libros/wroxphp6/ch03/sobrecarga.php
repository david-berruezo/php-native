<?php
/**
 * Created by PhpStorm.
 * User: David
 * Date: 07/06/2016
 * Time: 17:11
 */
class PropertyTest
{
    /**  Localización de los datos sobrecargados.  */
    private $data   = array();
    public  $prueba = 'Felicidad';

    /**  La sobrecarga no se usa en propiedades declaradas.  */
    public $declared = 1;

    /**  La sobre carga sólo funciona aquí al acceder desde fuera de la clase.  */
    private $hidden = 2;

    public function __set($name, $value)
    {
        echo "Estableciendo '$name' a '$value'\n";
        $this->data[$name] = $value;
    }

    public function __get($name)
    {
        echo "Consultando '$name'\n";
        if (array_key_exists($name, $this->data)) {
            return $this->data[$name];
        }
        $trace = debug_backtrace();
        trigger_error(
            'Propiedad indefinida mediante __get(): ' . $name .
            ' en ' . $trace[0]['file'] .
            ' en la línea ' . $trace[0]['line'],
            E_USER_NOTICE);
        return null;
    }

    /**  Desde PHP 5.1.0  */
    public function __isset($name)
    {
        echo "¿Está definido '$name'?\n";
        return isset($this->data[$name]);
    }

    /**  Desde PHP 5.1.0  */
    public function __unset($name)
    {
        echo "Eliminando '$name'\n";
        unset($this->data[$name]);
    }

    /**  No es un método mágico, esta aquí para completar el ejemplo.  */
    public function getHidden()
    {
        return $this->hidden;
    }
    public function printFelicidad(){
        echo ("Felicidad $this->prueba\n");
        echo ("Y otra de Felicidad '$this->prueba'\n");
        $valor = 6;
        echo 'También se pueden incluir nuevas líneas en
un string de esta forma, ya que es
correcto hacerlo así';
        echo ('Arnold una vez dijo: "I\'ll be back<br>"');
        echo ("Arnold una vez dijo:\n");
    }

    public function getPrueba(){
        return $this->prueba;
    }

}


echo "<pre>\n";

$obj = new PropertyTest;
$obj->a = 1;
echo $obj->a . "\n\n";

var_dump(isset($obj->a));
unset($obj->a);
var_dump(isset($obj->a));
echo "\n";

$obj->printFelicidad();

$nombre = "David";

echo $obj->declared . "\n\n";
echo "Vamos a probar con la propiedad privada que se llama 'hidden':\n";
echo "Las propiedades privadas pueden consultarse en la clase, por lo que no se usa __get()...\n";
echo $obj->getHidden() . "\n";
echo "Las propiedades privadas no son visibles fuera de la clase, por lo que se usa __get()...\n";
echo $obj->hidden . "\n";

$miTexto = <<<EOT
El resultado del ejemplo sería:
Estableciendo 'a' a '1'
Consultando 'a'
1
¿Está definido 'a'?
bool(true)
Eliminando 'a'
¿Está definido 'a'?
bool(false)
1
Vamos a probar con la propiedad privada que se llama 'hidden':
Las propiedades privadas pueden consultarse en la clase, por lo que no se usa __get()...
2
Las propiedades privadas no son visibles fuera de la clase, por lo que se usa __get()...
Consultando 'hidden'
Notice:  Propiedad indefinida mediante __get(): hidden en <file> en la línea 69 in <file>en la línea 28
EOT;
echo($miTexto);
echo ("\n");
$miTexto2 = <<<EOT
    Esto es una prueba $nombre
EOT;
echo($miTexto2);
echo ('Hola\\');
?>