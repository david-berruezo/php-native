<?php
$vector = array (
  0 =>
    array (
      'id'          => 3,
      'name'        => 'Sartenes',
      'url'         => 'http://localhost/php/php/domxpath/ficheros/ferreteria/sartenes.html',
      'parent'      => 2,
      'imagen'      => 'https://ferreteria.es/media/catalog/category/sartenes_1.jpg',
      'numeroHijos' => 30,
      'hijos' =>
        array (
          0 =>
            array (
              'id' => 4,
              'url' => 'http://localhost/php/php/domxpath/ficheros/ferreteria/packs-especiales.html',
              'name' => 'Packs especiales',
              'parent' => 3,
              'imagen' => 'https://ferreteria.es/media/catalog/category/packs-especiales_2.jpg',
              'numeroNietos' =>1,
              'nietos' =>
                array (
                  0 =>
                    array (
                      'id'        => 5,
                      'url'       => 'http://localhost/php/php/domxpath/ficheros/ferreteria/packs-castey.html',
                      'name'      => 'Packs Castey',
                      'parent'    => 4,
                      'imagen'    => 'https://ferreteria.es/media/catalog/category/packs-castey.jpg',
                     ),
                ),
            ),
            1 => array (
                'id' => 4,
                'url' => 'http://localhost/php/php/domxpath/ficheros/ferreteria/packs-especiales.html',
                'name' => 'Packs especiales',
                'parent' => 3,
                'imagen' => 'https://ferreteria.es/media/catalog/category/packs-especiales_2.jpg',
                'numeroNietos' =>1,
                'nietos' =>
                    array (
                        0 =>
                            array (
                                'id'        => 5,
                                'url'       => 'http://localhost/php/php/domxpath/ficheros/ferreteria/packs-castey.html',
                                'name'      => 'Packs Castey',
                                'parent'    => 4,
                                'imagen'    => 'https://ferreteria.es/media/catalog/category/packs-castey.jpg',
                            ),
                    ),
            ),
        ),
    ),
);
var_dump($vector);
$contador = 0;
foreach($vector[0]["hijos"] as &$hijo){
    var_dump($hijo);
    $hijo["name"] = "pepe";
    $contador++;
}
var_dump($vector);
?>