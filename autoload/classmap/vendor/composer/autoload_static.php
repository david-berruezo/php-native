<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInita7383deb6672ba7b27683d81a02b78e1
{
    public static $classMap = array (
        'MainController' => __DIR__ . '/../..' . '/controllers/MainController.php',
        'Model' => __DIR__ . '/../..' . '/models/Model.php',
        'View' => __DIR__ . '/../..' . '/views/View.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->classMap = ComposerStaticInita7383deb6672ba7b27683d81a02b78e1::$classMap;

        }, null, ClassLoader::class);
    }
}
