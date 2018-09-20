<?php
ini_set('display_errors', 1);
error_reporting( E_ALL );
// Varios destinatarios
$para  = 'davidberruezo@davidberruezo.com' . ', ';
// atención a la coma
$para .= 'davidberruezo@ecommercebarcelona360.com';
// título
$título = 'Recordatorio de cumpleaños para Agosto';
// mensaje
$mensaje = '
<html>
<head>
  <title>Recordatorio de cumpleaños para Agosto</title>
</head>
<body>
  <p>¡Estos son los cumpleaños para Agosto!</p>
  <table>
    <tr>
      <th>Quien</th><th>Día</th><th>Mes</th><th>Año</th>
    </tr>
    <tr>
      <td>Joe</td><td>3</td><td>Agosto</td><td>1970</td>
    </tr>
    <tr>
      <td>Sally</td><td>17</td><td>Agosto</td><td>1973</td>
    </tr>
  </table>
</body>
</html>
';
// Para enviar un correo HTML, debe establecerse la cabecera Content-type
$cabeceras  = 'MIME-Version: 1.0' . "\r\n";
$cabeceras .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
// Cabeceras adicionales
$cabeceras .= 'To: Mary <mary@example.com>, Kelly <kelly@example.com>' . "\r\n";
$cabeceras .= 'From: Recordatorio <davidberruezo33@gmail.com>' . "\r\n";
$cabeceras .= 'Cc: davidberruezo@davidberruezo.com' . "\r\n";
$cabeceras .= 'Bcc: davidberruezo@davidberruezo.com' . "\r\n";
// Enviarlo
mail($para, $título, $mensaje, $cabeceras);
?>