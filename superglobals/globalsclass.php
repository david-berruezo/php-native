<?php
namespace Proyecto\Superglobals;
/**
 * Created by PhpStorm.
 * User: David
 * Date: 06/07/2016
 * Time: 11:26
 */

class glb
{
    static public function set($name, $value)
{
    $GLOBALS[$name] = $value;
}

    static public function get($name)
{
    return $GLOBALS[$name];
}

}

$myglobalvar = 'Hello, World !';

function myfunction()
{
    $val = glb::get('myglobalvar');
    echo "$val\n";
    glb::set('myglobalvar', 'hi, again :)');
    $val = glb::get('myglobalvar');
    echo "$val\n";
}

myfunction();