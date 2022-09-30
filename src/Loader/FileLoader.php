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
        \PHPUnit\Util\FileLoader::checkAndLoad($filename);
    }
}
