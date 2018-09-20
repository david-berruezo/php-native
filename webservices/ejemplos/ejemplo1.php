<?php
/*
 * Getting API REST by file_get_contents
 */
$data = json_decode( file_get_contents('https://api.mercadolibre.com/users/226384143/'), true );
echo $data['nickname'];
print_r($data);
echo "<br><br>";

/*
 * Getting API REST by file_get_contents
 */

// Crea un nuevo recurso cURL
$ch = curl_init();
// Establece la URL y otras opciones apropiadas
curl_setopt($ch, CURLOPT_URL, "https://api.mercadolibre.com/users/226384143/");
curl_setopt($ch, CURLOPT_HEADER, 0);
// Captura la URL y la envía al navegador
$res = curl_exec($ch);
// Cierrar el recurso cURLy libera recursos del sistema
curl_close($ch);
echo "<br><br>";
print_r($res);
?>