<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit2250b832c0d8eb320d3f05f7254932e5
{
    public static $prefixLengthsPsr4 = array (
        'c' => 
        array (
            'clases\\' => 7,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'clases\\' => 
        array (
            0 => __DIR__ . '/../..' . '/clases',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit2250b832c0d8eb320d3f05f7254932e5::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit2250b832c0d8eb320d3f05f7254932e5::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
