<?php
/**r
 * Created by PhpStorm.
 * User: David
 * Date: 03/06/2016
 * Time: 15:33
 */

class Base{

    protected $variable1 = 'Soy una variable';

    public function  __construct(){
        echo('Entramos en el constructor Base');
    }

    protected function getVariable(){
        return $this->variable1;
    }

}

class SubBase extends Base{

    public function __construct(){
        parent::__construct();
        echo('Entramos en el constructor SubBase');
    }

    public function printVariable (){
        $variable = $this->getVariable();
        echo ('La variable es: '.$variable);
    }

}

$subclase = new SubBase();
$subclase->printVariable();