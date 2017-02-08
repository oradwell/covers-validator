<?php

namespace OckCyp\CoversValidator\Loader;

use PHPUnit\Util\Fileloader as PHPUnitFileloader;

class FileLoader
{
    /**
     * Include a file
     *
     * @param string $filename
     */
    public static function loadFile($filename)
    {
        PHPUnitFileloader::checkAndLoad($filename);
    }
}
