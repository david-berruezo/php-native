<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 20/06/2018
 * Time: 20:29
 */
class Model {
    private $name;

    /**
     * Model constructor.
     */
    public function __construct()
    {
        echo "Bienvenido al constructor Model -------Model-------<br>";
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

}
?>