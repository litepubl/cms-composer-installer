<?php

namespace litepubl\Composer;

use Composer\Installer\LibraryInstaller;
use Composer\Package\PackageInterface;

class Installer extends LibraryInstaller
{
    const TYPE = 'litepubl-core';
    const INSTALLDIR = 'litepubl-install-dir';

    private static $_installedPaths = array();

    /**
     * {@inheritDoc}
     */
    public function getInstallPath( PackageInterface $package )
    {
        $installDir = false;
        $prettyName      = $package->getPrettyName();
        if ($this->composer->getPackage() ) {
            $topExtra = $this->composer->getPackage()->getExtra();
            if (! empty($topExtra[static::INSTALLDIR]) ) {
                $installDir = $topExtra[static::INSTALLDIR];
                if (is_array($installDir) ) {
                    $installDir = empty($installDir[$prettyName]) ? false : $installDir[$prettyName];
                }
            }
        }
        $extra = $package->getExtra();
        if (! $installDir && ! empty($extra[static::INSTALLDIR]) ) {
            $installDir = $extra[static::INSTALLDIR];
        }
        if (! $installDir ) {
            $installDir = 'litepubl';
        }
        if (! empty(self::$_installedPaths[$installDir]) 
            && $prettyName !== self::$_installedPaths[$installDir]
        ) {
            throw new \InvalidArgumentException('Two packages cannot share the same directory!');
        }
        self::$_installedPaths[$installDir] = $prettyName;
        return $installDir;
    }

    /**
     * {@inheritDoc}
     */
    public function supports( $packageType ) 
    {
        return self::TYPE === $packageType;
    }

}
