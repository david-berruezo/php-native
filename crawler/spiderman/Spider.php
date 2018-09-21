<?php
namespace Crawler\Engine;

class Spider {
    const MAX_DOWNLOAD_SIZE = 1024*1024*100; // in bytes, =100kb
    const LOW_PRIORITY = 1024; // = Default
    const MEDIUM_PRIORITY = 512;
    const HIGH_PRIORITY = 256;

    private $options = array(
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_FORBID_REUSE   => true,
        CURLOPT_FRESH_CONNECT  => true,
        CURLOPT_HEADER         => false,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_MAXREDIRS      => 5,
        CURLOPT_TIMEOUT        => 5,
        CURLOPT_ENCODING       => ''
    );

    private $curl = null;
    private $url = null;
    private $urlParts = array();
    private $statusCode = null;
    private $source = null;

    public function __construct($url, $referer) {
        $this->options[CURLOPT_WRITEFUNCTION] = array($this, 'curl_handler_recv');
        $this->options[CURLOPT_REFERER] = $referer;
        $this->curl = curl_init();
        curl_setopt($this->curl, CURLOPT_URL, $url);
        curl_setopt_array($this->curl, $this->options);
        $this->source = '';
    }

    public function curl_handler_recv($curl, $data) {
        $this->source .= $data;
        if (strlen($this->source) > self::MAX_DOWNLOAD_SIZE) return 0;
        return strlen($data);
    }

    public function exec() {
        $start = round(microtime(true) * 1000);
        curl_exec($this->getCurl());

        $this->getUrl();
        $this->getStatusCode();

        curl_close($this->getCurl());
        return round(microtime(true) * 1000) - $start;
    }

    public function getCurl() {
        return $this->curl;
    }

    public function getSource() {
        return $this->source;
    }

    public function getUrl() {
        if (is_null($this->url)) {
            $this->url = curl_getinfo($this->getCurl(), CURLINFO_EFFECTIVE_URL);
            $this->urlParts = parse_url($this->url);
        }

        return $this->url;
    }

    public function getUrlParts($key = null) {
        if (!is_null($key) && isset($this->urlParts[$key])) {
            return $this->urlParts[$key];
        }

        return $this->urlParts;
    }

    public function getStatusCode() {
        if (is_null($this->statusCode)) {
            $this->statusCode = curl_getinfo($this->getCurl(), CURLINFO_HTTP_CODE);
        }

        return $this->statusCode;
    }
}