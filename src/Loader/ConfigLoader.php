<?php

namespace OckCyp\CoversValidator\Loader;

use PHPUnit_Util_Configuration as Configuration;

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
