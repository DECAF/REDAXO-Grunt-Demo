<?php

/**
 * @package redaxo\install
 */
class rex_install_archive
{
    public static function extract($archive, $dir, $basename)
    {
        $dir = rtrim($dir, '/\\');
        if (class_exists('ZipArchive')) {
            $tempdir = $dir . '.temp';
            $zip = new ZipArchive();
            if ($zip->open($archive)) {
                $success = $zip->extractTo($tempdir);
                $zip->close();
                rename($tempdir . '/' . $basename, $dir);
                rex_dir::delete($tempdir);
                return $success;
            }
            return false;
        }
        $archive = 'phar://' . $archive . '/' . $basename;
        return rex_dir::copy($archive, $dir);
    }

    public static function copyDirToArchive($dir, $archive, $basename = null, $excludeDirs = null)
    {
        $dir = rtrim($dir, '/\\');
        $basename = $basename ?: basename($dir);
        rex_dir::create(dirname($archive));
        $files = array();
        $iterator = rex_finder::factory($dir)->recursive()->filesOnly();
        if ($excludeDirs) {
            $iterator->ignoreDirs($excludeDirs, false);
        }
        foreach ($iterator as $path => $file) {
            $files[str_replace($dir, $basename, $path)] = $path;
        }
        if (class_exists('ZipArchive')) {
            $zip = new ZipArchive();
            $zip->open($archive, ZipArchive::CREATE);
            foreach ($files as $path => $realpath) {
                $zip->addFile($realpath, $path);
            }
            $zip->close();
        } else {
            $phar = new PharData($archive, 0, null, Phar::ZIP);
            $phar->buildFromIterator(new ArrayIterator($files));
            $phar->compressFiles(Phar::GZ);
            foreach ($files as $path => $realpath) {
                if (filesize($realpath) == 0) {
                    $phar[$path]->decompress();
                }
            }
        }
    }
}
