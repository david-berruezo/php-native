<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 21/10/17
 * Time: 19:41
 */

namespace clases;


class UrlsEmexs
{
   private $urls = [
    'https://www.mhapartments.com/',
    'http://www.avenidapalace.com/',
    'http://www.hotelterradets.com/',
    'http://hotelmiramarbarcelona.com/',
    'http://www.feelathomeapartments.com/',
    'http://www.enjoybcn.com/',
    'http://www.royalpasseigdegraciahotel.com/',
    'http://www.royalramblashotel.com/',
    'http://www.royalhotelsbcn.com/',
    'http://yurbban.com/',
    'http://www.universalholidaycentre.ru/',
    'http://www.universalholidaycentre.com/',
    'http://www.hotelduran.com/',
    'http://www.astoria7hotel.com/',
    'http://microdentsystem.com/',
    'http://umasuites.com/',
    'http://aesstrasteros.es/',
    'http://www.jardinesdenivaria.co.uk/',
    'http://entresd.es/',
    'http://www.sitgesgroup.com/',
    'http://www.hotelvillaemilia.com/',
    'http://emexs.es/',
    ];


    private $infoUrls = array();

    /*
     * Construimos el objeto
     */
    public function __construct()
    {
        echo "Bienvenido objeto Urls Emexs";
    }

    /*
     * Get Urls
     */
    public function getUrls(){
        return $this->urls;
    }

    /*
     * Set Result in this case only getInfo not getContent
     */
    public function setInfo($infoUrls){
        $this->infoUrls = $infoUrls;
    }


    /*
     * Send email
     */
    public function sendEmail(){
        foreach($this->infoUrls as $key=>$value){
            $status = $value["url"];
            $url    = $value["http_code"];
            echo "La url es: ".$url." y el status devuelto es: ".$status."<br>";
            if ( $status > 400 )
            {
                $myemail = "raquel.emexs@gmail.com";
                $myemail2 = "enric.emexs@gmail.com";
                $message_to_myemail = "ERROR de carga web $webs[$i]";
                $from  = "No carga: $webs[$i]: status $status.";
                mail($myemail, $message_to_myemail, $from);
                mail($myemail2, $message_to_myemail, $from);
            }

        }
    }
}
?>