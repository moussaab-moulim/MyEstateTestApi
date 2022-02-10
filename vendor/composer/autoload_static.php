<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit131d2d9c4b1304b239952caba421a1e7
{
    public static $prefixLengthsPsr4 = array (
        'F' => 
        array (
            'Firebase\\JWT\\' => 13,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Firebase\\JWT\\' => 
        array (
            0 => __DIR__ . '/..' . '/firebase/php-jwt/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit131d2d9c4b1304b239952caba421a1e7::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit131d2d9c4b1304b239952caba421a1e7::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit131d2d9c4b1304b239952caba421a1e7::$classMap;

        }, null, ClassLoader::class);
    }
}
