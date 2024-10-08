<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit85fd99db7308ae46e2b6f47070317fde
{
    public static $prefixLengthsPsr4 = array (
        'M' => 
        array (
            'MF\\' => 3,
        ),
        'A' => 
        array (
            'App\\' => 4,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'MF\\' => 
        array (
            0 => __DIR__ . '/..' . '/MF',
        ),
        'App\\' => 
        array (
            0 => __DIR__ . '/../..' . '/App',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit85fd99db7308ae46e2b6f47070317fde::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit85fd99db7308ae46e2b6f47070317fde::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit85fd99db7308ae46e2b6f47070317fde::$classMap;

        }, null, ClassLoader::class);
    }
}
