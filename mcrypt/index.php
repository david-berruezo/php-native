<?php
/*
$clave = hash('sha256', 'esta es una clave secreta', true);
$entrada = "Encontrémonos a las 9 en punto en el escondite.";
$td = mcrypt_module_open('rijndael-128', '', 'cbc', '');
$iv = mcrypt_create_iv(mcrypt_enc_get_iv_size($td), MCRYPT_DEV_URANDOM);
mcrypt_generic_init($td, $clave, $iv);
$datos_encriptados = mcrypt_generic($td, $entrada);
mcrypt_generic_deinit($td);
mcrypt_module_close($td);
*/
$clave = "Berruezin23";
echo "Codificiado es: ".sha1($clave)."<br>";
?>