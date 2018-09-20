<?php
/**
 * Created by PhpStorm.
 * User: David
 * Date: 21/07/2016
 * Time: 18:28
 */
include_once("config.php");
class db{

    // Object vars
    protected static $_instance = NULL;
    private $_pdo               = NULL;

    // Connection
    private $host               = host;
    private $dbname             = dbname;
    private $user               = user;
    private $password           = password;

    // Singletton
    public static function getInstance()
    {
        if (!self::$_instance instanceof self) {
            self::$_instance = new self;
        }
        return self::$_instance;
    }

    // Construct functions
    protected function __construct()
    {
        try {
            $database = new PDO('mysql:host='.$this->host.';dbname='.$this->dbname, $this->user, $this->password);
            // , array(PDO::ATTR_PERSISTENT => true)
            $this->_pdo = $database;
            //echo ("Conexion establecida con exito");
        } catch (PDOException $e) {
            print "¡Error!: " . $e->getMessage() . "<br/>";
            die();
        }
    }

    // Get pdo object
    public function getConnection(){
        return $this->_pdo;
    }
}