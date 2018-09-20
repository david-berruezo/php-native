<?php
/**
 * Mostrar twits de twitter
 * User: david
 * Date: 6/09/17
 * Time: 18:23
 */
namespace clases;
// Liberis
use clases\Twitter;
use TwitterAPIExchange;

class objetoTwitter{
    /*
     * variables privadas
     */
    private $settings;
    private $url;
    private $requestMethod;
    private $postfields;
    private $getfield;

    public function __construct()
    {
        /*
         * Creamos los settings
         */
        $this->settings = array(
            'oauth_access_token' => "4534253536-pvqViNiQ58cM9ct5WgBrMB4VGZXTcEA7p7kArjJ",
            'oauth_access_token_secret' => "qz3UuQZiuz31wKF8XrfyGjxmKAGzgxqbID2bQEINQ9xSN",
            'consumer_key' => "24R4Q3guGqY4BZfyTo0xdj6bp",
            'consumer_secret' => "cyvQDxJDcOn1RGkRc49riXob47lIU9qIJXlnBoVBkzH59fRRHE"
        );
        $this->url = 'https://api.twitter.com/1.1/statuses/user_timeline.json';
        $this->requestMethod = "GET";
    }

    /*
     * Devolver Tweets formato json
     */
    public function getCincoTweets() {
        $this->getfield = '?screen_name=eCommerceBcn360&count=5';
        $this->requestMethod = 'GET';
        $twitter = new TwitterAPIExchange($this->settings);
        var_dump($twitter);
        $json =  $twitter->setGetfield($this->getfield)
            ->buildOauth($this->url, $this->requestMethod)
            ->performRequest();

        echo "---------------------- Sacamos toda la parrafada de la mega api de twitter vaya basura ------------------<br><br>";
        var_dump($json);
        echo "---------------------- Fin basura ------------------<br><br>";
        return $json;
    }

    /*
     * Devolver Tweets Array multidimensional
     */
    public function getArrayTweets($jsonraw){

    }


    /*
     * Mostrar los datos
     */
    public function displayTable($rawdata){


    }
}
?>