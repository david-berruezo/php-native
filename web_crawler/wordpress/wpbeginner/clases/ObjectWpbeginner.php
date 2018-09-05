<?php
namespace clases;
use DOMDocument;
use DOMXPath;
use DateTime;
class ObjectWpbeginner {
    // Principal Vector
    private $categoriaPrincipal              = array();
    // Content cUrl
    private $indexContent                    = array();
    private $vectorDetalleContent            = array();
    // Directorios post
    private $vectorDirectorios               = array();
    private $contador                        = 0;

    /*
     * Constructor del objeto
     */
    public function __construct(){
        //libxml_use_internal_errors(true);
    }

    /*
     * Leemos todas las carpetas
     * del directorio G:\urlproyectos\wpbeginner.com\wp-tutorials
     * ya que serán todos los posts que tengamos
     */
    public function leerDirectorios(){
        $directorio = "G:\urlproyectos\wpbeginner.com\wp-tutorials";
        $ficheros   = scandir($directorio);
        $contador   = 0;
        foreach ($ficheros as $fichero){
            $temp = (string)$fichero;
            if ($contador == 0 xor $contador == 1 xor $temp == "index.html"){
                //echo "No nos interesa<br>";
            }else{
                array_push($this->vectorDirectorios,$fichero);
            }
            $contador++;
        }
    }

    /*
     * Devolvemos los directorios
     */
    public function getDirectorios(){
        return $this->vectorDirectorios;
    }

    /*
     * Guardar Index Content
     */
    public function setIndexContent($vectorContent){
        $this->indexContent = $vectorContent;
        $vectorCadena       = $this->scrapeIndex($this->indexContent);
        $contador           = 0;
        foreach($vectorCadena as $content){
           $this->leerUrls($content);
           $post = $this->queryPost($content,$contador);
           //$dom  = new DomDocument();
           //$dom->loadHTML($post);
           if ($contador == 0){
               //$dom->saveHTML();
               echo $post;
               //var_dump($post);
           }else{
               //$dom->saveHTML();
           }
           /*
           $dom        = new DomDocument();
           $dom->loadHTML($post);
           $htmlString = $dom->saveHTML($content);
           */
           array_push($this->vectorDetalleContent,$post);
           $contador++;
        }
        $this->borrarNulos();
        //$this->getCategoriaPrincipal();
        $this->writeCsv();
    }

    /*
     * Cortamos el set Index Content
     */
    public function scrapeIndex($contenidoVector){
        $inicio        = '<div id="content" class="hfeed">';
        $final         = '<div id="comments">';
        $cadena        = '';
        $vector        = array();
        $contador      = 0;
        foreach ($contenidoVector as $contenido){
            $cadenaContenido = rtrim(ltrim($contenido));
            //$cadena = $this->get_string_between($cadenaContenido,$inicio,$final);
            $pos1 = strpos($cadenaContenido, $inicio);
            $pos2 = strpos($cadenaContenido, $final);
            if ($pos1 !== false) {
                echo "Contador $contador se encontró 1 en la posición $pos1<br>";
            }
            if ($pos2 !== false) {
                echo "Contador $contador se encontró 2 en la posición $pos2<br>";
            }
            $cadena = substr($cadenaContenido,$pos1,$pos2);
            $cadena = utf8_decode($cadena);
            array_push($vector,$cadena);
            $contador++;
        }
        return $vector;
    }

    /*
     * Prueba para obtener string
     * entre 2 strings
     */

    private function get_string_between($string, $start, $end){
        $string = ' ' . $string;
        $ini = strpos($string, $start);
        if ($ini == 0) return '';
        $ini += strlen($start);
        echo ("ini vale:".$ini."<br>");
        $len = strpos($string, $end, $ini) - $ini;
        echo ("len vale:".$ini."<br>");
        return substr($string, $ini, $len);
    }

    /*
     * Leemos todas las urls
     * Creamos Padres,Hijos,Nietos
     * y Cogemos imagenes de Index
     */
    public function leerUrls($contenidoVector){
        $titulo                                                       = $this->queryTitulo($contenidoVector);
        $imagen                                                       = $this->queryImage($contenidoVector);
        $chalendar                                                    = $this->queryChalendar($contenidoVector);
        //$numComentarios                                               = $this->queryNumComentarios($contenidoVector);
        $this->categoriaPrincipal[$this->contador]                    = array();
        $this->categoriaPrincipal[$this->contador]["titulo"]          = $titulo;
        $this->categoriaPrincipal[$this->contador]["imagen"]          = $imagen;
        $this->categoriaPrincipal[$this->contador]["fecha"]           = $chalendar;
        //$this->categoriaPrincipal[$this->contador]["numComentarios"]  = $numComentarios;
        $this->contador++;
    }

    /*
     * Borramo los nulos
     */
    public function borrarNulos(){
        $contador = 0;
        foreach($this->categoriaPrincipal as $post){
            if ($post["titulo"] == null){
                unset($this->categoriaPrincipal[$contador]);
                unset($this->vectorDetalleContent[$contador]);
            }
            $contador++;
        }
        // Reindexamos el vector otra vez
        $this->categoriaPrincipal   = array_values($this->categoriaPrincipal);
        $this->vectorDetalleContent = array_values($this->vectorDetalleContent);
    }

    /*
     * Obtenemos las categorias principales
     */
    public function getCategoriaPrincipal(){
        //var_dump($this->categoriaPrincipal);
        //var_dump($this->vectorDetalleContent);
    }


    /*
     * Creamos csv
     */
    public function writeCsv(){
        // csv
        $output   = fopen('post_import.csv', 'w');
        $vector   = array();
        array_push($vector,$this->getLabelCsv());
        $contador = 0;
        foreach ($this->categoriaPrincipal as $value) {
            $id             = $contador + 1;
            $post_id        = $id;
            $post_name      = $value['titulo'];
            $post_author    = "editor@davidberruezo.com";
            //$post_date     = $this->convertDate($value['dia'],$value['mes']);
            $post_date      = $value['fecha'];
            $post_type      = "post";
            $post_status    = "publish";
            $post_tags      = "wordpress";
            $post_title     = $value['titulo'];
            $post_content   = $this->vectorDetalleContent[$contador];
            $post_category  = "wordpress";
            $custom_field1  = $value['imagen'];
            $custom_field2  = "left";
            $vectorCampos  = array($post_id,$post_name,$post_author,$post_date,$post_type,$post_status,$post_tags,$post_title,$post_content,$post_category,$custom_field1,$custom_field2);
            array_push($vector,$vectorCampos);
            $contador++;
        }
        foreach($vector as $field){
            fputcsv($output, $field,',');
        }
        fclose($output);
        //var_dump($this->categoriaPrincipal);
    }


    public function getLabelCsv(){
        $vector = array(
            "post_id",
            "post_name",
            "post_author",
            "post_date",
            "post_type",
            "post_status",
            "post_tags",
            "post_title",
            "post_content",
            "post_category",
            "Imagen",
            "posicion"
        );
        return $vector;
    }

    /*
     * Convertimos la fecha
     */
    public function convertDate($parametroDia,$parametroMes){
        $dia   = $parametroDia;
        $mes   = $parametroMes;
        $year  = '2016';
        $fecha = $dia.'-'.$mes.'-'.$year;
        $fechaActual = DateTime::createFromFormat('d-M-Y', $fecha);
        $fechaActual->format('Y-m-d');
        $fechaConvertida = $fechaActual->date;
        return $fechaConvertida;
    }

    /*
     * Consultamos el detalle del post
     */
    public function queryDetallePost($content){
        $dom               = new DOMDocument();
        $dom->loadHTML($content);
        $elemento          = $dom->getElementById("content");
        $tag               = '<div id="content" class="hfeed">';
        $htmlString        = $dom->saveHTML($tag->nodeValue);
        return $htmlString;
        /*
         $cadena = rtrim(ltrim($content));
         $dom   = new DomDocument();
         $dom->loadHTML($cadena);
         $xpath = new DOMXPath($dom);
         $tag   = "div";
         $consulta = "//div[contains(@class, 'post-')]";
         $nodeList = $xpath->query($consulta);
         $item              = $nodeList->item(0);
         var_dump($item->nodeValue);
         //$htmlString        = $dom->saveHTML($item->nodeValue);
         //var_dump($htmlString);
         */
    }

    public function queryPost($content,$contador){
        $cadena   = rtrim(ltrim($content));
        $dom      = new DomDocument();
        $dom->loadHTML($cadena);
        $xpath    = new DOMXPath($dom);
        $tag      = "div";
        $consulta = "//div[contains(@class, 'post-')]";
        $nodeList = $xpath->query($consulta);
        echo "La lista es: ".$nodeList->length."<br>";
        $item     = $nodeList->item(0);
        foreach ($item->childNodes as $child){
            $objeto     = get_class($child);
            if ($objeto == DOMElement) {
                if ($child->hasAttributes()){
                    echo "hay atributos<br>";
                    if ($child->hasAttribute("id")){
                        echo "El id es: ".$child->getAttribute("id")."<br>";
                        $id = $child->getAttribute("id");
                        // Encontramos child
                        if ($id == "horizontalsocial"){
                            echo "Entra 1<br>";
                            $child->parentNode->removeChild($child);
                            $child->nodeValue = "";
                            //$encontrado = true;
                        }else if ($id == "comments"){
                            echo "Entra 2<br>";
                            $child->parentNode->removeChild($child);
                            $child->nodeValue = "";
                        }
                    }else if ($child->hasAttribute("class")){
                        $class = $child->getAttribute("class");
                        if ($class == "author-box"){
                            echo "Entra 3<br>";
                            $child->parentNode->removeChild($child);
                            $child->nodeValue = "";
                            $encontrado = true;
                        }
                        if ($class == "singlerelated"){
                            echo "Entra 4<br>";
                            $child->parentNode->removeChild($child);
                            $child->nodeValue = "";
                            $encontrado = true;
                        }
                        if ($class == "singlecta"){
                            echo "Entra 5<br>";
                            $child->parentNode->removeChild($child);
                            $child->nodeValue = "";
                            $encontrado = true;
                        }
                    }
                }
                //$dom->saveHTML($item);
                //$dom->saveHTML();
            }
        }
        //return $item->nodeValue;
        return $dom->saveHTML($item);
    }

    /*
     * Query Titulo
     */
    public function queryTitulo($content){
        $dom               = new DOMDocument();
        $dom->loadHTML("$content");
        $xpath             = new DOMXPath($dom);
        $tag               = "h1";
        $class             = "entry-title";
        $consulta          = "//".$tag."[@class='".$class."']";
        $elemento          = $xpath->query($consulta);
        if ($elemento->length > 0){
            foreach($elemento as $element){
                $titulo = $element->nodeValue;
            }
        }
        //echo "El titulo es: ".$titulo."<br>";
        return $titulo;
    }

    /*
     * Query Chalendar
     */
    public function queryChalendar($content){
        $fecha             = "";
        $dom               = new DOMDocument();
        $dom->loadHTML("$content");
        $xpath             = new DOMXPath($dom);
        $tag               = "div";
        $class             = "singlepostinfo";
        $consulta          = "//".$tag."[@class='".$class."']";
        $elemento          = $xpath->query($consulta);
        if ($elemento->length > 0){
            foreach($elemento as $element){
                $tiempos = $element->getElementsByTagName("time");
                if ($tiempos->length > 0) {
                    foreach ($tiempos as $tiempo) {
                        $fecha = $tiempo->getAttribute("datetime");
                    }
                }
            }
        }
        return $fecha;
    }

    /*
     * Query Image
     */
    public function queryImage($content){
        $contador          = 0;
        $dom               = new DOMDocument();
        $dom->loadHTML("$content");
        $xpath             = new DOMXPath($dom);
        $tag               = "div";
        $class             = "singlethumb";
        $consulta          = "//".$tag."[@class='".$class."']";
        $elemento          = $xpath->query($consulta);
        if ($elemento->length > 0){
            foreach($elemento as $element){
                $imagenes = $element->getElementsByTagName("img");
                if ($imagenes->length > 0) {
                    foreach ($imagenes as $imagen) {
                        $ruta = $imagen->getAttribute("src");
                    }
                }
            }
        }
        return $ruta;
    }

    /*
     * Query num comentarios
     */
    public function queryNumComentarios($content,$contadorTotal){
        $contador          = 0;
        $numComentarios    = 0;
        $dom               = new DOMDocument();
        $dom->loadHTML("$content");
        $xpath             = new DOMXPath($dom);
        $tag               = "span";
        $class             = "comments";
        $consulta          = "//".$tag."[@class='".$class."']";
        $elemento          = $xpath->query($consulta);
        if ($elemento->length > 0){
            foreach($elemento as $element){
                if ($contador == $contadorTotal ){
                    $span         = $element;
                    $anchors      = $span->getElementsByTagName("a");
                    if ($anchors->length > 0) {
                        $anchor         = $anchors->item(0);
                        $numComentarios = $anchor->nodeValue;
                    }
                }
                $contador++;
            }
        }
        //echo "El numero de comentarios son: ".$numComentarios."<br>";
        return $numComentarios;
    }
}
?>