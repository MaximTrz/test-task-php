<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit44bdede25b27e8a9b12fbbb1567a67b1
{
    public static $prefixLengthsPsr4 = array (
        'P' => 
        array (
            'Psr\\Log\\' => 8,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Psr\\Log\\' => 
        array (
            0 => __DIR__ . '/..' . '/psr/log/Psr/Log',
        ),
    );

    public static $prefixesPsr0 = array (
        'B' => 
        array (
            'Bramus' => 
            array (
                0 => __DIR__ . '/..' . '/bramus/router/src',
            ),
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit44bdede25b27e8a9b12fbbb1567a67b1::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit44bdede25b27e8a9b12fbbb1567a67b1::$prefixDirsPsr4;
            $loader->prefixesPsr0 = ComposerStaticInit44bdede25b27e8a9b12fbbb1567a67b1::$prefixesPsr0;
            $loader->classMap = ComposerStaticInit44bdede25b27e8a9b12fbbb1567a67b1::$classMap;

        }, null, ClassLoader::class);
    }
}
