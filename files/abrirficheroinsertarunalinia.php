<?php
$dir   = "/mnt/david/htdocs/milano11/install/upgrade/sql";
$files = scandir($dir);
foreach($files as $key => $value){
    $path = realpath($dir.DIRECTORY_SEPARATOR.$value);
    if(!is_dir($path)) {
       $results[] = $path;
       $file = file_get_contents($path);
       $file_data = "SET sql_mode = 'ALLOW_INVALID_DATES';";
       $content = $file_data.$file;
       file_put_contents($path,$content);
        /*
       $output    = fopen($path, 'w');
       $file_data = "SET sql_mode = 'ALLOW_INVALID_DATES';";
       file_put_contents($path, $file_data);
       echo "el path es: ".$path."<br>";
       */
       //$nombreFichero       = explode("/",$path);
       //$nombreFichero       = $nombreFichero[count($nombreFichero)-1];
       //$this->vectorNombresFicheros[$path] = $nombreFichero;
    }
}
?>