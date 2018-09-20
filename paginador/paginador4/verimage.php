<?php

$width=80;
$height=20;
$lines=8;

/* Dichiara che lo stream trasmesso è un file immagine PNG */
header("Content-Type: image/png");

/* Inizializza la sessione */
session_start();

$verify="";
for ($i=0;$i<6;$i++)
$verify.=$i % 2==0?mt_rand(0,9):chr(mt_rand(65,90));
	
$_SESSION['verification_string']=$verify;

$im = imagecreate($width,$height);

$white = imagecolorallocate($im, 255, 255, 255);
$black = imagecolorallocate($im, 0, 0, 0);
$grey = imagecolorallocate($im, 150, 150, 150);

imagefill($im, 0,0, $black);


for ($i=0;$i<$lines;$i++)
{
	if ($i % 2==0)//pari=linee verticali
	{
		
		$x1=mt_rand(0,$width);
		$y1=0;
		$x2=$x1;
		$y2=$height;
	}
	else //dispari=linee orizzontali
	{
		$x1=0;
		$y1=mt_rand(0,$height);
		$x2=$width;
		$y2=$y1;
	}
	imageline($im, $x1, $y1, $x2, $y2, $grey);
}


/* seleziona un font a caso tra quelli di sistema */
$font=mt_rand(3,5);

$w=strlen($verify)*imagefontwidth($font);
$h=imagefontheight($font);

$x=mt_rand(1,($width-$w-1));
$y=mt_rand(1,($height-$h-1));
imagestring($im, $font, $x, $y, $verify, $white);



/* output al browser*/
imagepng($im);

/* Distruggo l'immagine in memoria */
imagedestroy($im);

?>