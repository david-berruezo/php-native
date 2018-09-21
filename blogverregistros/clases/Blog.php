<?php
namespace clases;
use PDO;
use PHPExcel;
use PHPExcel_IOFactory;
use PHPExcel_Shared_Font;
use PHPExcel_Style_Border;
use PHPExcel_Style_Borders;
use PHPExcel_Style_Alignment;
use PHPExcel_Worksheet_PageSetup;
/**
 * Created by David Berruezo.
 * User: david
 * Date: 14/07/17
 * Time: 9:23
 */
class Blog{
  /*
   * Var
   */
  private $conexion;
  private $language = "";

  public function __construct()
  {
    //echo "Hola Blog<br>";
  }

  /*
   * Conectamos a la base de datos
   */

  /*
  public function connectDatabase(){
      // Local
      try {
          $usuario        = "root";
          $contraseña     = "Berruezin23";
          $this->conexion = new PDO('mysql:host=localhost;dbname=wordpressprueba', $usuario, $contraseña);
          $this->conexion->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
      } catch (PDOException $e) {
          print "¡Error!: " . $e->getMessage() . "<br/>";
          die();
      }
  }
  */

  /*
   * Connect Database English
   */
  public function connectDatabaseEnglish(){
        // Local
        try {
            $usuario        = "blogen";
            $contraseña     = "Berruezin23";
            $this->conexion = new PDO('mysql:host=localhost;dbname=blogteden', $usuario, $contraseña);
            $this->conexion->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            print "¡Error!: " . $e->getMessage() . "<br/>";
            die();
        }
  }


    /*
     * Connect Database Spanish
     */
    public function connectDatabaseSpanish(){
        // Local
        try {
            $usuario        = "bloges";
            $contraseña     = "Berruezin23";
            $this->conexion = new PDO('mysql:host=localhost;dbname=blogtedes', $usuario, $contraseña);
            $this->conexion->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            print "¡Error!: " . $e->getMessage() . "<br/>";
            die();
        }
    }

    /*
     * Connect Database Spanish
     */
    public function connectDatabaseFrench(){
        // Local
        try {
            $usuario        = "blogfr";
            $contraseña     = "Berruezin23";
            $this->conexion = new PDO('mysql:host=localhost;dbname=blogtedfr', $usuario, $contraseña);
            $this->conexion->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            print "¡Error!: " . $e->getMessage() . "<br/>";
            die();
        }
    }

    public function setLanguage($_language){
        $this->language = $_language;
    }

  /*
   * Consultamos a la base de datos
   */
   public function queryDatabase(){
       // Objeto Excel
       $objPHPExcel = new PHPExcel();
       // Set document properties
       $objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
           ->setLastModifiedBy("Maarten Balliauw")
           ->setTitle("PHPExcel Test Document")
           ->setSubject("PHPExcel Test Document")
           ->setDescription("Test document for PHPExcel, generated using PHP classes.")
           ->setKeywords("office PHPExcel php")
           ->setCategory("Test row file");
       // Set Orientation, size and scaling
       $objPHPExcel->setActiveSheetIndex(0);
       $objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_DEFAULT);
       $objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
       $objPHPExcel->getActiveSheet()->getPageSetup()->setFitToHeight(0);
       // Añadimos los campos etiquetas correspondientes a las columnas
       $objPHPExcel->setActiveSheetIndex(0)
           ->setCellValue('A1', 'email')
           ->setCellValue('B1', 'name')
           ->setCellValue('C1', 'dropdown')
           ->setCellValue('D1', 'comment')
           ->setCellValue('E1', 'stage')
           ->setCellValue('F1', 'idioma')
           ->setCellValue('G1', 'gender')
           ->setCellValue('H1', 'lastname')
           ->setCellValue('I1', 'company')
           ->setCellValue('J1', 'companyindustry')
           ->setCellValue('K1', 'vat')
           ->setCellValue('L1', 'address')
           ->setCellValue('M1', 'ted_brand_name')
           ->setCellValue('N1', 'mobile_phone')
           ->setCellValue('O1', 'born_date')
           ->setCellValue('P1', 'country')
           ->setCellValue('Q1', 'city')
           ->setCellValue('R1', 'first_registration_date')
           ->setCellValue('S1', 'subscriber')
           ->setCellValue('T1', 'satisfaction')
           ->setCellValue('U1', 'description')
           ->setCellValue('V1', 'purchase')
           ->setCellValue('W1', 'customizer')
           ->setCellValue('X1', 'brandcreator');
        // Database
       $query="SELECT *
FROM formulario";
       $stmt         = $this->conexion->prepare( $query );
       $stmt->execute();
       $contadorCeldas = 2;
       while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            /*
            $row["total_paid_tax_incl"];
            array_push($this->pedidosCorrectos,$row);
            */
            $objPHPExcel->getActiveSheet()
               ->setCellValue('A' . $contadorCeldas,$row["email"])
               ->setCellValue('B' . $contadorCeldas,$row["name"])
               ->setCellValue('C' . $contadorCeldas,$row["dropdown"])
               ->setCellValue('D' . $contadorCeldas,$row["comment"])
               ->setCellValue('E' . $contadorCeldas,$row["stage"])
               ->setCellValue('F' . $contadorCeldas,$row["idioma"])
               ->setCellValue('G' . $contadorCeldas,$row["gender"])
               ->setCellValue('H' . $contadorCeldas,$row["lastname"])
               ->setCellValue('I' . $contadorCeldas,$row["company"])
               ->setCellValue('J' . $contadorCeldas,$row["companyindustry"])
               ->setCellValue('K' . $contadorCeldas,$row["vat"])
               ->setCellValue('L' . $contadorCeldas,$row["address"])
               ->setCellValue('M' . $contadorCeldas,$row["ted_brand_name"])
               ->setCellValue('N' . $contadorCeldas,$row["mobile_phone"])
               ->setCellValue('O' . $contadorCeldas,$row["born_date"])
               ->setCellValue('P' . $contadorCeldas,$row["country"])
               ->setCellValue('Q' . $contadorCeldas,$row["city"])
               ->setCellValue('R' . $contadorCeldas,$row["first_registration_date"])
               ->setCellValue('S' . $contadorCeldas,$row["subscriber"])
               ->setCellValue('T' . $contadorCeldas,$row["satisfaction"])
               ->setCellValue('U' . $contadorCeldas,$row["description"])
               ->setCellValue('V' . $contadorCeldas,$row["purchase"])
               ->setCellValue('W' . $contadorCeldas,$row["customizer"])
               ->setCellValue('X' . $contadorCeldas,$row["brandcreator"]);
            $contadorCeldas++;
       }
       // Guardamos el excel
       $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
       if ($this->language == "es"){
           $objWriter->save('clientes_es.xlsx');
       }else if ($this->language == "fr"){
           $objWriter->save('clientes_fr.xlsx');
       }else if ($this->language == "en"){
           $objWriter->save('clientes_en.xlsx');
       }

    }
}
?>