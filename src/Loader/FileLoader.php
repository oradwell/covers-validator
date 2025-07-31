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
        if (class_exists(\PHPUnit\Util\FileLoader::class, true)) {
            \PHPUnit\Util\FileLoader::checkAndLoad($filename);
            return;
        }

        include_once $filename;
    }
}
