<?php

class GIFImage extends GDImage {

  public function __construct( $filename ) {
    $this->handle = imagecreatefromjpeg( $filename );
  }

};

?>
