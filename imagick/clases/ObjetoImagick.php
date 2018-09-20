<?php
namespace clases;
use Imagick;
/**
 * Created by PhpStorm.
 * User: david
 * Date: 14/07/17
 * Time: 6:18
 */
class ObjetoImagick{
    /*
     * var
     */
    private $dummyimgs;
    private $watermark;

    public function __construct()
    {
        //echo "Construimos el objeto<br>";
        /*
         * Errores
         */
        ini_set('display_errors', 1);
        error_reporting( E_ALL );
        $this->dummyimgs = new Imagick();
        $this->watermark = new Imagick();
    }
}
?>