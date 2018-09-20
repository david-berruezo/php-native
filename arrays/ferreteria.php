<?php
/**
 * Created by PhpStorm.
 * User: David
 * Date: 11/09/2016
 * Time: 9:39
 */
$categorias = array(
    0 => array(
      'id'          => 3,
      'name'        => 'Sartenes',
      'url'         => 'http://localhost/php/php/domxpath/ficheros/ferreteria/sartenes.html',
      'parent'      => 2,
      'imagen'      => 'https://ferreteria.es/media/catalog/category/sartenes_1.jpg',
      'numeroHijos' => 30,
      'content'     => 'contenido',
      'hijos'       => array(
        0 => array(
            'id'           => 4,
            'url'          => 'http://localhost/php/php/domxpath/ficheros/ferreteria/packs-especiales.html',
            'name'         => 'Packs especiales',
            'parent'       => 3,
            'imagen'       => 'https://ferreteria.es/media/catalog/category/packs-especiales_2.jpg',
            'numeroNietos' => 1,
            'content'      => 'contenido',
              'nietos'     => array(
                  0 => array(
                      'id'          => 5,
                      'url'         => 'http://localhost/php/php/domxpath/ficheros/ferreteria/packs-castey.html',
                      'name'        => 'Packs Castey',
                      'parent'      => 4,
                      'imagen'      => 'https://ferreteria.es/media/catalog/category/packs-castey.jpg',
                      'content'     => 'contenido',
                      'productos'   => array(

                      ),
                      'numeroProductos' => 25
                  )
              )
        )
      )
    )
);
foreach ($categorias as $categoria){
   foreach($categoria["hijos"] as $hijo){
     foreach($hijo["nietos"] as $nietos){
         echo "Nietos url: ".$nietos["url"]."<br>";
     }
     echo "Hijo url: ".$hijo["url"]."<br>";
   }
   echo "Padre url: ".$categoria["url"]."<br>";
}
echo "hola";
?>