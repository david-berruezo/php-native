<?php

abstract class GDImage {
  public static function createImage( $filename ) {
    $info = getimagesize( $filename );
    $type = $info[2];

    switch ( $type ) {
      case IMAGETYPE_JPEG:
       return new JPEGImage( $filename );
 
     case IMAGETYPE_PNG:
       return new PNGImage( $filename );

      case IMAGETYPE_GIF:
       return new GIFImage( $filename );
    }

    return null;
  }
};

include_once('JPEGImage.class.php');
include_once('PNGImage.class.php');
include_once('GIFImage.class.php');

?>
