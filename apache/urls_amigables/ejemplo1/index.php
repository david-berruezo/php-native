<?php
// Descripcion
/*
 * Le pasamos los siguientes parametros
 * http://localhost/php/php/apache/urls_amigables/ejemplo1/nombre/david
 * http://localhost/php/php/apache/urls_amigables/ejemplo1/producto/1-movil.html
 * http://localhost/php/php/apache/urls_amigables/ejemplo1/fichero/archivo.html
 * http://localhost/php/php/apache/urls_amigables/ejemplo1/paginas/pagina1
 * http://localhost/php/php/apache/urls_amigables/ejemplo1/paginas/pagina2
 * http://localhost/php/php/apache/urls_amigables/ejemplo1/paginitas/pagina1
 * http://localhost/php/php/apache/urls_amigables/ejemplo1/paginitas/pagina2
 */

// Esto seria como un controller
echo "<h1>Estamos en el index</h1>";
if (isset($_GET['tipo']) && $_GET['tipo'] == "nombre"){
    echo "El nombre es: ".$_GET['nombre']."<br>";
}else if(isset($_GET['tipo']) && $_GET['tipo'] == "producto"){
    echo "El producto es: ".$_GET['nombre']."<br>";
    echo "El id producto es: ".$_GET['id_producto']."<br>";
}else if(isset($_GET['tipo']) && $_GET['tipo'] == "fichero"){
    echo "El id producto es: ".$_GET['fichero']."<br>";
}else if(isset($_GET['pagina'])){
    include_once(__DIR__."./paginas/".$_GET['pagina'].".html");
}else if(isset($_GET['paginita'])){
    include_once(__DIR__."./paginas/".$_GET['paginita'].".php");
}
?>