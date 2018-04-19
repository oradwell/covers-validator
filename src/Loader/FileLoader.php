<?php

namespace OckCyp\CoversValidator\Loader;

class FileLoader
{
    /**
     * Include a file
     *
     * @param string $filename
     */
    public static function loadFile($filename)
    {
        if (class_exists(\PHPUnit\Util\FileLoader::class))
        {
            // PHPUnit 7.x+
            \PHPUnit\Util\FileLoader::checkAndLoad($filename);
        }
        else
        {
            // PHPUnit 6.x-
            \PHPUnit\Util\Fileloader::checkAndLoad($filename);
        }
    }
}
