<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 14/02/17
 * Time: 9:55
 * Tratamiento de cabeceras
 */


/*
 * Obtenemos todas las cabeceras
 */

$headers = apache_request_headers();
foreach ($headers as $header => $value) {
    echo "$header: $value <br />\n";
}
?>