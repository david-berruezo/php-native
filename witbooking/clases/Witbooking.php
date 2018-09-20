<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 1/10/17
 * Time: 16:25
 */
namespace clases;
use clases\Curlrequest;
class Witbooking{
    // var
    var $url         = 'https://api.witbooking.com/endpoint/';
    var $username    = 'desarrollo.emexs@gmail.com';
    var $password    = 'EPi7TeA610gDZW';
    var $headers     = array();
    var $aParams     = array();
    var $curlrequest = "";
    public function __construct()
    {
        echo "Construimos la clase";
        $this->headers     = array('username:'.$this->username,'password:'.$this->password);
        $this->curlrequest = new Curlrequest();
        date_default_timezone_set('Europe/Madrid');
    }

    function get_hotels(){
        $this->aParams=array();
        $url = $this->url.'hotelTickers';
        return json_decode( $this->curlrequest->get($url,'GET',false,$this->headers) , 1);
    }
}
?>