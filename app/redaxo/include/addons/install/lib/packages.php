<?php

/**
 * @package redaxo\install
 */
class rex_install_packages
{
    private static $updatePackages;
    private static $addPackages;
    private static $myPackages;

    public static function getUpdatePackages()
    {
        if (is_array(self::$updatePackages)) {
            return self::$updatePackages;
        }

        self::$updatePackages = self::getPackages();

        foreach (self::$updatePackages as $key => $addon) {
            if (is_dir(rex_path::addon($key)) && isset($addon['files'])) {
                self::unsetOlderVersions($key, OOAddon::getVersion($key));
            } else {
                unset(self::$updatePackages[$key]);
            }
        }
        return self::$updatePackages;
    }

    public static function updatedPackage($package, $fileId)
    {
        self::unsetOlderVersions($package, self::$updatePackages[$package]['files'][$fileId]['version']);
    }

    private static function unsetOlderVersions($package, $version)
    {
        foreach (self::$updatePackages[$package]['files'] as $fileId => $file) {
            if (empty($version) || empty($file['version']) || rex_string::versionCompare($file['version'], $version, '<=')) {
                unset(self::$updatePackages[$package]['files'][$fileId]);
            }
        }
        if (empty(self::$updatePackages[$package]['files'])) {
            unset(self::$updatePackages[$package]);
        }
    }

    public static function getAddPackages()
    {
        if (is_array(self::$addPackages)) {
            return self::$addPackages;
        }

        self::$addPackages = self::getPackages();
        /*foreach (self::$addPackages as $key => $addon) {
            if (is_dir(rex_path::addon($key))) {
                unset(self::$addPackages[$key]);
            }
        }*/
        return self::$addPackages;
    }

    public static function addedPackage($package)
    {
        //unset(self::$addPackages[$package]);
        self::$myPackages = null;
    }

    public static function getMyPackages()
    {
        if (is_array(self::$myPackages)) {
            return self::$myPackages;
        }

        self::$myPackages = self::getPackages('?only_my=1');
        foreach (self::$myPackages as $key => $addon) {
            if (!is_dir(rex_path::addon($key))) {
                unset(self::$myPackages[$key]);
            }
        }
        return self::$myPackages;
    }

    public static function getPath($path = '')
    {
        return 'packages/' . $path;
    }

    private static function getPackages($path = '')
    {
        return rex_install_webservice::getJson(self::getPath($path));
    }

    public static function deleteCache()
    {
        self::$updatePackages = null;
        self::$addPackages = null;
        self::$myPackages = null;
        rex_install_webservice::deleteCache('packages/');
    }
}
