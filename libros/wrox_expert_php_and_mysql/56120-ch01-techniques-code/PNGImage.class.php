<?php

class PNGImage extends GDImage {

  public function __construct( $filename ) {
    $this->handle = imagecreatefrompng( $filename );
  }

};

?>
