<?php
namespace clases;
// Clases
use Dom;
use DOMXPath;
use DOMDocument;
// PhpMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
class Objectpublidata{
    // Vectores datos
    private $nproductos                      = 0;
    private $npages                          = 0;
    private $urls_detalle                    = array();
    private $vectorObjetosPublidata          = array();
    // Vectores Content
    private $indexContent                    = array();

    /*
     * Constructor del objeto
     */
    public function __construct()
    {
        // echo "creamos objeto publidata<br>";
    }


    /*
     * Guardar Index Content
     */
    public function setIndexContent($vectorContent){
        $this->indexContent        = $vectorContent[0];
        $this->set_pages();
    }


    /*
     * Public function setPages
     */
    private function set_pages(){
        // mostrando
        $dom            = new DOMDocument();
        $dom->loadHTML("$this->indexContent");
        $xpath          = new DOMXPath($dom);
        $atributoValue  = "mostrando";
        $tag            = "p";
        $consulta       = "//".$tag."[@class='".$atributoValue."']";
        $elements       = $xpath->query($consulta);
        if ($elements->length > 0) {
            foreach ($elements as $element) {
                $resultados     = $element->textContent;
                $mis_resultados = explode('resultados',$resultados);
                $mis_resultados[0]  = str_replace("Se han encontrado","",$mis_resultados[0]);
                $mis_resultados[0]  = ltrim(rtrim($mis_resultados[0]));
                $this->nproductos = $mis_resultados[0];
                $this->npages     = ceil($this->nproductos / 10);
                //echo $resultados;
                //echo "El número de registros són: ".$mis_resultados[0]." y el número de páginas son:".$this->npages."<br>";
            }
        }
    }


    /*
     * Get Pages
     */
    public function getPages(){
        return $this->npages;
    }


    /*
    * Guardar All Content
    */
    public function setAllContent($vectorContent){
        $this->indexContent = $vectorContent[0];
        $this->saveContent();
    }


    /*
     * Save content page by page
     */
    private function saveContent(){
        // mostrando
        $dom            = new DOMDocument();
        $dom->loadHTML("$this->indexContent");
        $xpath          = new DOMXPath($dom);
        $atributoValue  = "tituloEmp";
        $tag            = "span";
        $consulta       = "//".$tag."[@class='".$atributoValue."']";
        $elements       = $xpath->query($consulta);
        if ($elements->length > 0) {
            foreach ($elements as $element) {
                $anchors = $element->getElementsByTagName("a");
                foreach ($anchors as $anchor) {
                    $this->urls_detalle[] = $this->convertirUrl($anchor->getAttribute("href"));
                }
            }
        }
    }


    /*
     * Convertimos la url
     */
    private function convertirUrl($url){
        $url = "http://www.publidata.es".$url;
        return $url;
    }

    /*
     * Return urls detalle
     *
     */
    public function get_urls_detalle(){
        return $this->urls_detalle;
    }

    /*
     * Guardar Index Content
     */
    public function setDetalleContent($vectorContent){
        $this->indexContent        = $vectorContent[0];
        $this->set_detail_info();
    }


    /*
     * Set Detail Info
     */
    private function set_detail_info(){
        # Creamos las propiedades del objeto
        $nombre    = "";
        $subtitulo = "";
        $calle     = "";
        $cp        = "";
        $ciudad    = "";
        $web_data  = "";
        # vectores pq tienen varios datos
        $emails_vector    = array();
        $telefonos_vector = array();
        $equipos_vector   = array();
        $cargos_vector    = array();
        # Creamos el objeto DomDocument y DomXpath
        $dom            = new DOMDocument();
        $dom->loadHTML("$this->indexContent");
        $element        = $dom->getElementById("detalle");
        $xpath          = new DOMXPath($dom);
        echo "-------------------- Valores -----------------<br>";
        // Nombre Empresa
        $atributoValue  = "moduleContent3";
        $tag            = "div";
        $consulta       = "//".$tag."[@class='".$atributoValue."']";
        $titulos        = $xpath->query($consulta,$element);
        if ($titulos->length > 0) {
            foreach ($titulos as $titulo) {
                $headings = $titulo->getElementsByTagName("h1");
                if ($headings->length > 0) {
                    foreach ($headings as $headings_uno) {
                        echo "La empresa es: ".$headings_uno->textContent."<br>";
                        $nombre = $headings_uno->textContent;
                    }
                }
            }
        }
        // Segundo nombre de empresa
        $atributoValue  = "direccion2";
        $tag            = "dt";
        $consulta       = "//".$tag."[@class='".$atributoValue."']";
        $titulos_dos    = $xpath->query($consulta,$element);
        if ($titulos_dos->length > 0) {
            foreach ($titulos_dos as $titulo) {
                $headings = $titulo->getElementsByTagName("strong");
                if ($headings->length > 0) {
                    foreach ($headings as $headings_uno) {
                        echo "El segundo titulo de la empresa es: ".$headings_uno->textContent."<br>";
                        $subtitulo = $headings_uno->textContent;
                    }
                }
            }
        }
        // Direcciones remplazar
        $atributoValue  = "direccionDef";
        $tag            = "dd";
        $consulta       = "//".$tag."[@class='".$atributoValue."']";
        $direcciones    = $xpath->query($consulta,$element);
        if ($direcciones->length > 0) {
            foreach ($direcciones as $direccion) {
                $brs = $direccion->getElementsByTagName('br');
                foreach ($brs as $node) {
                    $node->parentNode->replaceChild($dom->createTextNode("|"), $node);
                }
            }
        }
        // Direcciones busqueda
        $atributoValue  = "direccionDef";
        $tag            = "dd";
        $consulta       = "//".$tag."[@class='".$atributoValue."']";
        $direcciones    = $xpath->query($consulta,$element);
        if ($direcciones->length > 0) {
            foreach ($direcciones as $direccion) {
                $direccion_total = $direccion->nodeValue;
                $direccion_total = explode("|",$direccion_total);
            }
            $ciudad = substr($direccion_total[1],strlen($direccion_total[1])-9,strlen($direccion_total[1]));
            $direccion_total[1] = substr($direccion_total[1],0,strlen($direccion_total[1])-9);
            $direccion_total[2] = $ciudad;
        }
        //print_r($direccion_total);
        $calle  = $direccion_total[0];
        $cp     = $direccion_total[1];
        $ciudad = $direccion_total[2];
        //print_r($direccion_total);
        //echo "<br>";
        echo "Calle: ".$calle."<br>";
        echo "Cp: ".$cp."<br>";
        echo "Ciudad: ".$ciudad."<br>";
        // Telefonos
        $atributoValue  = "telefono";
        $tag            = "dt";
        $consulta       = "//".$tag."[@class='".$atributoValue."']";
        $telefonos      = $xpath->query($consulta,$element);
        if ($telefonos->length > 0) {
            foreach ($telefonos as $telf) {
                $objeto = $telf->nextSibling;
                $telfs = explode("-",$objeto->nodeValue);
                if (count($telfs) > 0){
                    foreach($telfs as $t){
                        echo "El telf es: ".$t."<br>";
                        $telefonos_vector[] = $t;
                    }
                }else{
                    echo "El telf es: ".$objeto->nodeValue."<br>";
                    $telefonos_vector[] = $objeto->nodeValue;
                }
            }
        }
        // Email
        $atributoValue  = "email";
        $tag            = "dd";
        $consulta       = "//".$tag."[@class='".$atributoValue."']";
        $emails         = $xpath->query($consulta,$element);
        if ($emails->length > 0) {
            foreach ($emails as $mail) {
                $losemails = $mail->getElementsByTagName("a");
                if ($losemails->length > 0) {
                    foreach ($losemails as $losemail) {
                        $nuevo_email = str_replace("mailto:","",$losemail->getAttribute("href"));
                        echo "email: ".$nuevo_email."<br>";
                        $emails_vector[] = $nuevo_email;
                    }
                }
            }
        }
        // Web
        $atributoValue  = "web";
        $tag            = "dd";
        $consulta       = "//".$tag."[@class='".$atributoValue."']";
        $webs           = $xpath->query($consulta,$element);
        if ($webs->length > 0) {
            foreach ($webs as $web) {
                $lawebs = $web->getElementsByTagName("a");
                if ($lawebs->length > 0) {
                    foreach ($lawebs as $web) {
                        echo "web: ".$web->getAttribute("href")."<br>";
                        $web_data = $web->getAttribute("href");
                    }
                }
            }
        }
        // Equipos Remplazar
        $atributoValue  = "equipo";
        $tag            = "dl";
        $consulta       = "//".$tag."[@class='".$atributoValue."']";
        $equipo_element  = $xpath->query($consulta,$element);
        if ($equipo_element->length > 0) {
            foreach ($equipo_element as $eq) {
               //print_r($eq);
               $brs = $eq->getElementsByTagName('br');
               //print_r($brs);
               if ($brs->length > 0) {
                    foreach ($brs as $node) {
                       $node->parentNode->replaceChild($dom->createTextNode("|"), $node);
                       //print_r($node);
                    }
                }
            }
        }
        // Equipos
        $atributoValue   = "equipo";
        $tag             = "dl";
        $consulta        = "//".$tag."[@class='".$atributoValue."']";
        $equipo_element  = $xpath->query($consulta,$element);
        if ($equipo_element->length > 0) {
            foreach ($equipo_element as $eq) {
                $equipos_totales = $eq->getElementsByTagName("dd");
                if ($equipos_totales->length > 0) {
                    foreach ($equipos_totales as $equipos_totales_bueno) {
                        $equipo_total = $equipos_totales_bueno->nodeValue;
                        $equipo_total = explode("|",$equipo_total);
                        //print_r($equipo_total);
                        $equipo_temp      = explode(",",$equipo_total[0]);
                        $equipos_vector[] = $equipo_temp[0];
                        $cargos_vector[]  = $equipo_temp[1];
                        echo "El equipo es: ".$equipo_temp[0]."<br>";
                        echo "El cargo es: ".$equipo_temp[1]."<br>";
                    }
                }
            }
        }
        // Guardamos todos los datos
        $publidata = new Publidata();
        $publidata->setNombre($nombre);
        $publidata->setSubtitulo($subtitulo);
        $publidata->setCalle($calle);
        $publidata->setCp($cp);
        $publidata->setCiudad($ciudad);
        $publidata->setWeb($web_data);
        $publidata->setEmails($emails_vector);
        $publidata->setTelefonos($telefonos_vector);
        $publidata->setEquipos($equipos_vector);
        $publidata->setCargos($cargos_vector);
        $this->vectorObjetosPublidata[] = $publidata;
        print_r($publidata);
        echo "-------------------- Fin Valores -----------------<br>";
        echo "<br><br><br><br>";
    }


    /*
     * Send email
     */
    public function send_email(){
        foreach ($this->vectorObjetosPublidata as $objeto){
            $misemails = $objeto->getEmails();
            $equipos   = $objeto->getEquipos();
            $cargos    = $objeto->getCargos();
            foreach($misemails as $miemail){
                $this->send($miemail,$equipos,$cargos);
            }
        }
    }

    private function send($email,$equipos,$cargos){
        $cadena = "A la atención de ";
        for ($i=0;$i<count($equipos);$i++){
            $cadena.= $equipos[$i]." , ".$cargos[$i]." | ";
        }
        # Save document with agraiments
        if (count($equipos) > 0 && $email != "csingla@netsense.es"){
            $dom_one            = new DOMDocument();
            $dom_one->loadHTMLFile("curriculum/index_es.html");
            $elemento       = $dom_one->getElementById("agradecimientos");
            $elemento->textContent = $cadena;
            $dom_one->saveHTMLFile("curriculum/index_es.html");
        }
        # Send Email
        $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
        try {
            // Server settings
            $mail->SMTPDebug = 2;                                 // Enable verbose debug output
            //$mail->isSMTP();                                      // Set mailer to use SMTP
            $mail->Host = 'mail.davidberruezo.com';  // Specify main and backup SMTP servers
            $mail->SMTPAuth = true;                               // Enable SMTP authentication
            $mail->Username = 'davidberruezo@davidberruezo.com';                 // SMTP username
            $mail->Password = 'Berruezin23';                           // SMTP password
            $mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
            $mail->Port = 25;                                    // TCP port to connect to
            // Recipients
            $mail->setFrom('davidberruezo@davidberruezo.com', 'David Berruezo,');
            //$mail->addAddress('davidberruezo@davidberruezo.com', 'David Berruezo');     // Add a recipient
            $mail->addAddress($email, 'David Berruezo');
            //$mail->addAddress('davidberruezo@ecommercebarcelona360.com');               // Name is optional
            //$mail->addReplyTo('davidberruezo@ecommercebarcelona360.com', 'Information');
            //$mail->addCC('cc@example.com');
            //$mail->addBCC('bcc@example.com');
            //Attachments
            //$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
            //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
            //Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = 'Me llamo David Berruezo, estoy buscando trabajo en Barcelona, como programador PHP,Javascript u otros';
            //$mail->Body    = 'This is the HTML message body <b>in bold!</b>';
            $mail->Body = file_get_contents('curriculum/index_es.html');
            $mail->AltBody = 'Buscando trabajo en Barcelona';
            $mail->send();
            echo 'Message has been sent<br>';
        } catch (Exception $e) {
            echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo."<br>";
        }
    }
}
?>