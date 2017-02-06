<?php

namespace OckCyp\CoversValidator\Loader;

use PHPUnit\Util\Fileloader as PHPUnitFileLoader;

class FileLoader
{
    /**
     * Include a file
     *
     * @param string $filename
     */
    public static function loadFile($filename)
    {
        PHPUnitFileLoader::checkAndLoad($filename);
    }
}
