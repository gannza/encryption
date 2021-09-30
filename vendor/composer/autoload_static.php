<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit1d31e8bfc79e5b75b17d4251a724872e
{
    public static $prefixLengthsPsr4 = array (
        'P' => 
        array (
            'Plectrum\\Encryption\\' => 20,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Plectrum\\Encryption\\' => 
        array (
            0 => __DIR__ . '/..' . '/plectrum/encryption/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit1d31e8bfc79e5b75b17d4251a724872e::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit1d31e8bfc79e5b75b17d4251a724872e::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit1d31e8bfc79e5b75b17d4251a724872e::$classMap;

        }, null, ClassLoader::class);
    }
}