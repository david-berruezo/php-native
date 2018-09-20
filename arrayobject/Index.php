<?php
/**
 * Created by PhpStorm.
 * User: David
 * Date: 27/01/2016
 * Time: 17:49
 */

namespace ArrayObject;
require_once 'View.php';

// create an instance of the View class and assign some properties to it
$view = new View(array(
    'header'  => 'This is the header section',
    'content' => 'This the content section',
    'footer'  => 'This is the footer section'
));


echo $view->render();