<?php
/**
 * Created by PhpStorm.
 * User: David
 * Date: 08/07/2016
 * Time: 8:10
 */

class Singleton{
    protected static $instane = NULL;
    protected $handler        = NULL;
    private $db               = NULL;
    public static function getInstance()
    {
        if (!self::$instance instanceof self){
            self::$instance = new self;
        }
        return self::$instane;
    }
    public function update(){

    }
    /*
     * Conectamos a la base de datos
     */
    public function conection(){
        try {
            $usuario    = "root";
            $contraseña = "Berruezin23";
            $this->db   = new PDO('mysql:host=localhost;dbname=davidber_web', $usuario, $contraseña);
            //$this->db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            print "¡Error!: " . $e->getMessage() . "<br/>";
            die();
        }
    }

    /*
     * Hacemos una consulta
     */
    public function consulta1(){

        /*
        $consulta = $this->db->prepare("
        SELECT pr.id,pr.titulo,pr.idCategoria,pi.id as idimagen, pi.imagen,pc.categoria,pd.proyectoDesc,e.nombre as nombreEmpresa,pi.portada,pi.portada_cuadros
        FROM proyectos as pr
        JOIN proyectos_imagenes as pi
        ON pr.id = pi.id_proyecto
        JOIN proyectos_categorias as pc
        ON pr.idCategoria = pc.id
        JOIN proyectos_desc as pd
        ON pr.id = pd.id_proyecto
        JOIN proyectos_empresas as pe
        ON pe.id = pd.id_proyecto
        JOIN empresas as e
        ON e.id = pe.id_empresa
        where pd.id_idioma=2 and pi.portada_cuadros IS NULL and pr.id = 1");
        */
        $consulta = $this->db->prepare("SELECT * FROM proyectos");
        sleep(5);
        $resultados = $consulta->execute();
        while ($fila = $consulta->fetch()) {
            print(" ----------- Resultados -------------<br>");
            print_r($fila);
            print ("-------------------------------------<br>");
        }
        $consulta = null;
        $this->db = null;

        /*
        $sth = $mbd->query('SELECT * FROM foo');
        // Ya se ha terminado; se cierra
        $sth = null;
        $mbd = null;
        $consulta->execute();
        print("Obtener todas las filas restantes del conjunto de resultados:\n");
        $resultado = $consulta->fetchAssoc();
        print_r($resultado);
        //query the product table and join to the image table and return any images, if we have any, for each product
        $sql = "SELECT * FROM product, image LEFT OUTER JOIN image ON (product.product_id = image.product_id)";
        $array = $stmt->fetchAll(PDO::FETCH_ASSOC);
        print_r($array);
        */
    }
}