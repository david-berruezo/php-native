<?php
$vector = array("david");
echo "Printeamos un array:<br>";
var_dump($vector);
echo "<br>";
echo "Printeamos un json object con json_decode:<br>";
$json = '{"a":1,"b":2,"c":3,"d":4,"e":5}';
var_dump(json_decode($json));
$conversion_a_objeto = json_decode($json);
echo "<br>";
echo "Accedemos a la propiedades a,b,c del objeto convertido en json mediante json_encode:<br>";
echo "Propiedad a vale: ".$conversion_a_objeto->a."<br>";
echo "Propiedad b vale: ".$conversion_a_objeto->b."<br>";
echo "Propiedad c vale: ".$conversion_a_objeto->c."<br>";
echo "Printeamos un array indexada con json_encode:<br>";
$arr = array('a' => 1, 'b' => 2, 'c' => 3, 'd' => 4, 'e' => 5);
echo json_encode($arr);
echo "<br>";
/*
 * Agregamos otro objeto json
 */
$json_string = '{
    "name": "David",
    "apellido":"Berruezo",
    "telefono": [
        "fijo":"932176757",
        "movil":"615231533",
     ],
    "estudios":[
        "estudio"{
            "titulo":"fp2"
        },
        "estudio"{
            "titulo":"Grau Multimedia"
        },
    ]
}';
var_dump(json_encode($json_string));
?>