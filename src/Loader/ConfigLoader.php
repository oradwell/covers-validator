<?php

namespace OckCyp\CoversValidator\Loader;

use PHPUnit\Util\Configuration;

class ConfigLoader
{
    /**
     * Load configuration from file
     *
     * @param string $fileName
     * @return Configuration
     */
    public static function loadConfig($fileName)
    {
        return Configuration::getInstance($fileName);
    }
}
