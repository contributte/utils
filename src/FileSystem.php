<?php

namespace Contributte\Utils;

use Nette\Utils\FileSystem as NetteFileSystem;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

/**
 * @author Milan Felix Sulc <sulcmil@gmail.com>
 */
class FileSystem extends NetteFileSystem
{

    /**
     * Normalize path
     *
     * @param string $path
     * @return string
     */
    public static function pathalize($path)
    {
        return str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $path);
    }

    /**
     * Get file extension(.xxx)
     *
     * @param string $str
     * @return string
     */
    public static function extension($str)
    {
        $pos = strripos($str, '.');
        if ($pos === FALSE) {
            return pathinfo($str, PATHINFO_EXTENSION);
        }

        return substr($str, $pos);
    }

    /**
     * Purges directory
     *
     * @param string $dir
     * @return void
     */
    public static function purge($dir)
    {
        if (!is_dir($dir)) {
            mkdir($dir);
        }

        foreach (new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir, RecursiveDirectoryIterator::SKIP_DOTS), RecursiveIteratorIterator::CHILD_FIRST) as $entry) {
            if ($entry->isDir()) {
                rmdir($entry);
            } else {
                unlink($entry);
            }
        }
    }

}
