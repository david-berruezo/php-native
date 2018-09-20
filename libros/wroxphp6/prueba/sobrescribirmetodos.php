<?php
/**r
 * Created by PhpStorm.
 * User: David
 * Date: 03/06/2016
 * Time: 15:33
 */

class Base{

    protected $variable1 = 'Soy una variable';
    protected $variable2 = 'Soy una variable 2';
    protected $variable3 = 'Soy una variable 3';

    public function  __construct(){
        echo('Entramos en el constructor Base');
    }

    public function getVariable(){
        return $this->variable1;
    }

    protected function getVariable2(){
        return $this->variable2;
    }

    private function getVariable3(){
        return $this->variable3;
    }

    public function devolverVariable3(){
        return $this->getVariable3();
    }

}

class SubBase extends Base{

    protected $variable1 = 'Soy otra variable';
    protected $variable2 = 'Soy la otra variable 2';
    protected $variable3 = 'Soy la otra variable 3';

    public function __construct(){
        parent::__construct();
        echo('Entramos en el constructor SubBase');
    }

    public function getVariable(){
        return $this->variable1;
    }

    public function printVariable (){
        $variable  = $this->getVariable();
        $variable2 = $this->getVariable2();
        $variable3 = $this->devolverVariable3();
        echo ('La variable es: '.$variable.' y la variable 2 es: '.$variable2.' y la variable 3 es: '.$variable3);
    }

    protected function getVariable2(){
        return $this->variable2;
    }

    public function devolverVariable3(){
        return $this->variable3;
    }
}

$subclase = new SubBase();
$subclase->printVariable();
