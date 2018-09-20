<?
  session_start();
 
  $img = imagecreate(400,100);
  $captcha = "";
  for ( $i=rand(5,7); $i >= 0; $i-- )
    $catcha .= chr(rand(ord('A'),ord('Z')));
 
  $white = imagecolorallocate($im, 255, 255, 255);
  $black = imagecolorallocate($im, 0, 0, 0);
 
  imagestring($img, 5, 3, 3, $captcha, $black);
 
  header("Content-type:image/jpeg");
  imagejpeg($img);

  $_SESSION['captcha'] = $captcha;
?>