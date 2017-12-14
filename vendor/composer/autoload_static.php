<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit9791f190c7b23c9dbb2a1a43c8b877ff
{
    public static $files = array (
        '0e6d7bf4a5811bfa5cf40c5ccd6fae6a' => __DIR__ . '/..' . '/symfony/polyfill-mbstring/bootstrap.php',
    );

    public static $prefixLengthsPsr4 = array (
        'T' => 
        array (
            'Twig\\' => 5,
        ),
        'S' => 
        array (
            'Symfony\\Polyfill\\Mbstring\\' => 26,
        ),
        'M' => 
        array (
            'Medoo\\' => 6,
        ),
        'A' => 
        array (
            'App\\Models\\' => 11,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Twig\\' => 
        array (
            0 => __DIR__ . '/..' . '/twig/twig/src',
        ),
        'Symfony\\Polyfill\\Mbstring\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/polyfill-mbstring',
        ),
        'Medoo\\' => 
        array (
            0 => __DIR__ . '/..' . '/catfan/medoo/src',
        ),
        'App\\Models\\' => 
        array (
            0 => __DIR__ . '/../..' . '/application/models',
        ),
    );

    public static $prefixesPsr0 = array (
        'T' => 
        array (
            'Twig_' => 
            array (
                0 => __DIR__ . '/..' . '/twig/twig/lib',
            ),
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit9791f190c7b23c9dbb2a1a43c8b877ff::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit9791f190c7b23c9dbb2a1a43c8b877ff::$prefixDirsPsr4;
            $loader->prefixesPsr0 = ComposerStaticInit9791f190c7b23c9dbb2a1a43c8b877ff::$prefixesPsr0;

        }, null, ClassLoader::class);
    }
}