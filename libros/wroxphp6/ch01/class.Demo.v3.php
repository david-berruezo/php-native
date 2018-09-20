<?php
class Demo {
    private $_name;
    public function sayHello() {
      print "Hello " . $this->getName() . "!";
    }
    public function getName() {
      return $this->_name;
    }
    public function setName($name) {
      if(!is_string($name) || strlen($name) == 0) {
          try {
              throw new Exception("Invalid name value!");
          } catch (Exception $e) {
              echo('<br>'.'Ha habido el siguiente mensaje de error: '.$e.'<br>');
          }
      }else{
          $this->_name = $name;
      }
    }

    public function __destruct(){
        echo ('Si quisieramos llamar a alguna funcuón para hacer algún cambio o modificación o escritura en el objeto hacerlo');
        echo ('Ejemplo cerrar la conexión de la base de datos');
        echo('Destruimos el objeto');
    }
}
?>