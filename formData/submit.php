<?php
/*
 * Array de FILES es
 */
/*
$vector = array(
    "file1" => array(
        "name"     => "MyFile.txt (comes from the browser, so treat as tainted)",
        "type"     => "text/plain  (not sure where it gets this from - assume the browser, so treat as tainted)",
        "tmp_name" => "tmp/php/php1h4j1o (could be anywhere on your system, depending on your config settings, but the user has no control, so this isn't tainted)",
        "error"    => "UPLOAD_ERR_OK  (= 0)",
        "size"     => "123   (the size in bytes)"
    )
);
*/

/*
 * Recibimos parámetros
 */
/*
echo ("Recibimos post parametros <br>\n");
var_dump($_POST);
echo ("Recibimos files parametros <br>\n");
var_dump([$_FILES]);
echo ("Inspeccionamos fichero <br>\n");
*/

if(isset($_FILES["userfile"])) {
    /*
    $error = false;
    $files = array();
    $uploaddir = '/uploads';
    echo("name: " . $_FILES["userfile"]["name"] . "<br>\n");
    echo("type: " . $_FILES["userfile"]["type"] . "<br>\n");
    echo("tmp_name: " . $_FILES["userfile"]["tmp_name"] . "<br>\n");
    echo("error: " . $_FILES["userfile"]["error"] . "<br>\n");
    echo("size: " . $_FILES["userfile"]["size"] . "<br>\n");
    $dir_subida = 'uploads/';
    $fichero_subido = $dir_subida . basename($_FILES['userfile']['name']);
    if (move_uploaded_file($_FILES['userfile']['tmp_name'], $fichero_subido)) {
        echo "El fichero es válido y se subió con éxito.\n";
    } else {
        echo "¡Posible ataque de subida de ficheros!\n";
    }
    foreach ($_FILES["userfile"] as $file) {
        echo("valor: " . $file . "<br>\n");
    }
    */
}else if(isset($_FILES["file"])){
    $dir_subida = 'uploads/';
    $objeto = json_decode($_POST["objeto"]);
    $vector = array();
     foreach($objeto as $object){
         $vector1 = array(
            "idimagen"=>$object->idimagen
         );
         array_push($vector,$vector1);
    }
    $file_ary = reArrayFiles($_FILES['file']);
    $contador = 0;
    foreach ($file_ary as $file) {
        print "----------- FICHERO -----------<br>\n";
        print 'File Name: ' . $file['name'] . "<br>\n";
        print 'File Type: ' . $file['type'] . "<br>\n";
        print 'File Size: ' . $file['size'] . "<br>\n";
        print 'File tmp_name: ' . $file['tmp_name'] . "<br>\n";
        print 'Error: ' . $file['error'] . "<br>\n";
        print ("llave: ".key($file_ary)."<br>\n");
        $fichero_subido = $dir_subida . basename($file['name']);
        if (move_uploaded_file($file['tmp_name'], $fichero_subido)) {
            echo "El fichero es válido y se subió con éxito.<br>\n";
        } else {
            echo "¡Posible ataque de subida de ficheros!<br>\n";
        }
        print "----------- FIN -----------<br>\n";
        $file_ary[$contador]["idimagen"] = $vector[$contador]["idimagen"];
        $contador++;
    }
}else{

}

/*
 * Reagrupa los múltiples ficheros
 * en un vector
 */
function reArrayFiles(&$file_post) {
    $file_ary   = array();
    $file_count = count($file_post['name']);
    $file_keys  = array_keys($file_post);
    for ($i=0; $i<$file_count; $i++) {
        foreach ($file_keys as $key) {
            $file_ary[$i][$key] = $file_post[$key][$i];
        }
    }
    return $file_ary;
}
?>