<?php header("Content-Type: text/html;charset=utf-8"); ?>
<?php
/**
 * User: David Berruezo
 * Date: 25/07/2016
 * Time: 20:05
 */
// Database Pdo Singletton
// require_once("database.php");
// Objects
// require_once("proyecto.php");
// require_once("caracteristica.php");
// require_once("imagen.php");
// Factory objects
// require_once("proyectoFactory.php");
// require_once("caracteristicasFactory.php");
// require_once("imagenesFactory.php");
// Collection class objects
// require_once("class.Collection.php");
class Application{
   // var Object
   private $proyectos;
    /*
     * Evaluamos todos los parametros por get y post
     */
    public function __construct()
    {
        /*
        // Proyectos collection
        $this->proyectos       = new Collection();
        // Get
        if (isset($_GET["funcion"])) {
            switch ($_GET["funcion"]) {
                case "read":
                    $this->proyectos->setLoadCallback('readAll', $this);
                    $this->proyectos->getItems();
                break;
                case "readOneFront":
                    $this->proyectos->setLoadCallback('readOneFront', $this);
                    $this->proyectos->getItems();
                break;
                case "readOne":
                    $this->readOne();
                break;
                case "update":
                    $this->update();
                break;
                case "delete":
                    $this->delete();
                break;
                case "nada":
                    $vector = array("response" => true);
                    echo json_encode($vector);
                break;
            }
        }else if (isset($_FILES["file"])){
            // Borrados
            $borrados = $_POST["borrados"];
            $findme   = ',';
            $pos = strpos($borrados, $findme);
            if ($pos === false) {
                //echo "Es una sola imagen";
                $vectorBorrados = array();
                array_push($vectorBorrados,$borrados);
            } else {
                //echo "Don muchas imagenes";
                $vectorBorrados = array();
                $vectorBorrados = explode(",",$borrados);
            }
            // Subidos
            $dir_subida = '../images/'.$_POST["idproyecto"].'/';
            $objeto = json_decode($_POST["objeto"]);
            $idproyecto = $_POST["idproyecto"];
            $vector = array();
            foreach($objeto as $object){
                $vector1 = array(
                    "idimagen"=>$object->idimagen
                );
                array_push($vector,$vector1);
            }
            $file_ary = $this->reArrayFiles($_FILES['file']);
            $contador = 0;
            foreach ($file_ary as $file) {
                //print "----------- FICHERO -----------<br>\n";
                //print 'File Name: ' . $file['name'] . "<br>\n";
                //print 'File Type: ' . $file['type'] . "<br>\n";
                //print 'File Size: ' . $file['size'] . "<br>\n";
                //print 'File tmp_name: ' . $file['tmp_name'] . "<br>\n";
                //print 'Error: ' . $file['error'] . "<br>\n";
                //print ("llave: ".key($file_ary)."<br>\n");
                $fichero_subido = $dir_subida . basename($file['name']);
                if (move_uploaded_file($file['tmp_name'], $fichero_subido)) {
                    //echo "El fichero es válido y se subió con éxito.<br>\n";
                } else {
                    //echo "¡Posible ataque de subida de ficheros!<br>\n";
                }
                //print "----------- FIN -----------<br>\n";
                $file_ary[$contador]["idimagen"]   = $vector[$contador]["idimagen"];
                $file_ary[$contador]["idproyecto"] = $idproyecto;
                $contador++;
            }
            //var_dump($file_ary);
            //var_dump($vectorBorrados);
            $this->saveUpdateImagenes($file_ary,$vectorBorrados);
        }else if (isset($_POST["borrados"])){
            $borrados = $_POST["borrados"];
            $findme   = ',';
            $pos = strpos($borrados, $findme);
            if ($pos === false) {
                //echo "Es solo una imagen";
                $vectorBorrados = array();
                array_push($vectorBorrados,$borrados);
            } else {
                //echo "Es mas de una imagen";
                $vectorBorrados = array();
                $vectorBorrados = explode(",",$borrados);
            }
            $this->deleteImagenes($vectorBorrados);
        }else if (isset($_POST['funcion']) && $_POST['funcion'] == "create"){
            $this->create();
        // Formularios insertar actualizar
        }else if(isset($_POST['funcion']) && $_POST['funcion'] == "update"){
            $this->saveUpdate();
        }else if(isset($_POST['funcion']) && $_POST['funcion'] == "delete") {
            $this->delete();
        }
        */
    }

    /*
     * Reagrupa los múltiples ficheros
     * en un vector
     */
    public function reArrayFiles(&$file_post) {
        $file_ary   = array();
        $file_count = count($file_post['name']);
        $file_keys  = array_keys($file_post);
        for ($i=0; $i<$file_count; $i++) {
            foreach ($file_keys as $key) {
                $file_ary[$i][$key] = $file_post[$key][$i];
            }
        }
        return $file_ary;
    }

    /*
     * Read all projects
     * Front end Backend
     */
    public function readAll(Collection $col){
        $proyectoFactory = new ProyectoFactory();
        $paginador       = $proyectoFactory->getAll($col);
        $proyectos       = $this->proyectos->getItems();
        //var_dump($proyectos);
        $productos       = array();
        $contador        = 0;
        foreach($proyectos as $proyecto){
            $productos[$contador]['id']                             = $proyecto->getId();
            $productos[$contador]['name']                           = $proyecto->getName();
            $productos[$contador]['description']                    = $proyecto->getDescription();
            $productos[$contador]['created']                        = $proyecto->getCreated();
            $productos[$contador]['url']                            = $proyecto->getUrl();
            $productos[$contador]['download']                       = $proyecto->getDownload();
            $imagenes                                               = $proyecto->getImagenes()->getItems();
            if (is_array($imagenes) && sizeof($imagenes)){
                //var_dump($imagenes);
                foreach($imagenes as $imagen){
                    $productos[$contador]['imagenes']                 = array();
                    $productos[$contador]['imagenes']['id']           = $imagen->getId();
                    $productos[$contador]['imagenes']['rutaGrande']   = $imagen->getRutaGrande();
                    $productos[$contador]['imagenes']['rutaPeke']     = $imagen->getRutaPeke();
                    $productos[$contador]['imagenes']['portada']      = $imagen->getPortada();
                    $productos[$contador]['imagenes']['idproyecto']   = $imagen->getIdproyecto();
                }
            }
            $contador++;
        }
        $resp               = array();
        $resp['response']   = true;
        $resp['msg']        = "List successfully";
        $resp['productos']  = $productos;
        $resp['valor']      = $paginador;
        echo json_encode($resp);
    }
    /*
     * Read one project by id
     * Front end
     */
    public function readOneFront(Collection $col){
        $proyectoFactory = new ProyectoFactory();
        $proy            = $proyectoFactory->readOneFront($col);
        $proyectos       = $this->proyectos->getItems();
        //var_dump($proyectos);
        $productos       = array();
        $contador        = 0;
        $contadorImagen  = 0;
        $contadorCarac   = 0;
        foreach($proyectos as $proyecto){
            $productos[$contador]['id']                             = $proyecto->getId();
            $productos[$contador]['name']                           = $proyecto->getName();
            $productos[$contador]['description']                    = $proyecto->getDescription();
            $productos[$contador]['created']                        = $proyecto->getCreated();
            $productos[$contador]['url']                            = $proyecto->getUrl();
            $productos[$contador]['download']                       = $proyecto->getDownload();
            $productos[$contador]['description_large']              = $proyecto->getDescription_large();
            $productos[$contador]['modified']                       = $proyecto->getModified();
            $imagenes                                               = $proyecto->getImagenes()->getItems();
            $caracteristicas                                        = $proyecto->getCaracteristicas()->getItems();
            if (is_array($imagenes) && sizeof($imagenes)){
                //var_dump($imagenes);
                $productos[$contador]['imagenes']                                      = array();
                foreach($imagenes as $imagen){
                    $productos[$contador]['imagenes'][$contadorImagen]['id']           = $imagen->getId();
                    $productos[$contador]['imagenes'][$contadorImagen]['rutaGrande']   = $imagen->getRutaGrande();
                    $productos[$contador]['imagenes'][$contadorImagen]['rutaPeke']     = $imagen->getRutaPeke();
                    $productos[$contador]['imagenes'][$contadorImagen]['portada']      = $imagen->getPortada();
                    $productos[$contador]['imagenes'][$contadorImagen]['idproyecto']   = $imagen->getIdproyecto();
                    $contadorImagen++;
                }
            }
            if (is_array($caracteristicas) && sizeof($caracteristicas)){
                //var_dump($imagenes);
                $productos[$contador]['caracteristicas']                                     = array();
                foreach($caracteristicas as $caracteristica){
                    $productos[$contador]['caracteristicas'][$contadorCarac]['id']           = $caracteristica->getIdcaracteristica();
                    $productos[$contador]['caracteristicas'][$contadorCarac]['valor']        = $caracteristica->getValor();
                    $productos[$contador]['caracteristicas'][$contadorCarac]['value']        = $caracteristica->getValue();
                    $productos[$contador]['caracteristicas'][$contadorCarac]['idproyecto']   = $caracteristica->getIdproyecto();
                    $contadorCarac++;
                }
            }
            $contador++;
        }
        $resp               = array();
        $resp['response']   = true;
        $resp['msg']        = "Project successfully";
        $resp['productos']  = $productos;
        echo json_encode($resp);
    }

    /*
     * Update product form
     * Solamente guardamos el
     * objeto Proyecto sin las
     * colecciones imagenes y categorias
     */
    public function saveUpdate(){
        $proyectoFactory = new ProyectoFactory();
        $proyectoFactory->update();
    }

    /*
     * Update images
     */
    public function saveUpdateImagenes($vectorImagenes,$borrados){
        $imagenesFactory = new ImagenesFactory();
        $imagenesFactory->updateImagenes($vectorImagenes,$borrados);
    }

    /*
     * Borramos imagenes cuando solo se han borrado
     * ni se han modificado ni se han insertado
     */
    public function deleteImagenes($borrados){
        $imagenesFactory = new ImagenesFactory();
        $imagenesFactory->deleteImagenes($borrados);
    }

    /*
     * Creamos un nuevo proyecto
     */
    public function create(){
        $proyectoFactory = new ProyectoFactory();
        $proyectoFactory->create();
    }

    /*
     * Delete a project
     * Delete
     */
    public function delete(){
        $proyectoFactory = new ProyectoFactory();
        $proyectoFactory->delete();
    }


    /*
     * get Proyectos collection
     */
    public function getProyectos(){
        return $this->proyectos;
    }
}
// Instanciamos nuestro objeto aplicacion
$aplicacion = new Application();
?>