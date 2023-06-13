<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit9a2564864685f30fdff88ba523bd1c9c
{
    public static $prefixLengthsPsr4 = array (
        'N' => 
        array (
            'Nullix\\CryptoJsAes\\' => 19,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Nullix\\CryptoJsAes\\' => 
        array (
            0 => __DIR__ . '/..' . '/brainfoolong/cryptojs-aes-php/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit9a2564864685f30fdff88ba523bd1c9c::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit9a2564864685f30fdff88ba523bd1c9c::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit9a2564864685f30fdff88ba523bd1c9c::$classMap;

        }, null, ClassLoader::class);
    }
}