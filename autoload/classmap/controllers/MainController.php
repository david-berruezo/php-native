<?php


class MainController{
    private $name;
    private $surname;

    /**
     * MainController constructor.
     * @param $name
     */
    public function __construct()
    {
        echo "Bienvenido al constructor MainController -------Controllers-------<br>";
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

    /**
     * @return mixed
     */
    public function getSurname()
    {
        return $this->surname;
    }

    /**
     * @param mixed $surname
     */
    public function setSurname($surname)
    {
        $this->surname = $surname;
    }
}
?>