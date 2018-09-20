<?php
    function loadclass($class)
    {
        require_once __DIR__ . DIRECTORY_SEPARATOR . $class . '.php';
    }
    spl_autoload_register('loadclass');
?>