<?php
/**
 * Probar xdebug.
 * User: david
 * Date: 5/04/17
 * Time: 9:55
 */

function dump($value) {
    echo '<pre>';
    var_dump($value);
    echo '</pre>';
}

$vector = array(
    'Bernat'   => 'Ceo',
    'Francesc' => 'Ceo',
    'Jordi'    => 'Ceo',
);

dump($vector);

