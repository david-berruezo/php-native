<?php

class RESTRequestProxy {

  public $service;
  public $resource;

  public function __construct($service_url, $resource) {
    $this->service = $service_url;
    $this->resource = $resource;
  }

  public function create($data) {
     return $this->exec(null,"POST",$data);
  }

  public function edit($id, $data) {
     return $this->exec($id,"PUT",$data);
  }

  public function delete($id) {
    return $this->exec($id,"DELETE");
  }

  public function get($id) {
     return $this->exec($id,"GET");
  }

  private function exec($id=null, $method="GET", $post=false) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL,
      "{$this->service}/{$this->resource}".($id? "/$id" : "").".json" );
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
    $data = curl_exec($ch);

    if ( $data === false )
      throw new Exception("Error making REST request. ".curl_error($ch));

    if ( curl_getinfo( $ch, CURLINFO_HTTP_CODE ) >= 400 )
      throw new Exception("An HTTP error ". curl_getinfo( $ch, CURLINFO_HTTP_CODE ) . " occurred");

    curl_close($ch);
    return json_decode($data);
  }

};

?>