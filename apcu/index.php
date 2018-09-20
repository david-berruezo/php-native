<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 19/11/17
 * Time: 18:48
 */

$bar = 'BAR';
apcu_add('foo', $bar);
var_dump(apcu_fetch('foo'));
echo "\n";
$bar = 'NEVER GETS SET';
apcu_add('foo', $bar);
var_dump(apcu_fetch('foo'));
echo "\n";
?>
