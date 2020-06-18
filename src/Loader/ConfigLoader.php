<?php

namespace OckCyp\CoversValidator\Loader;

use OckCyp\CoversValidator\Model\ConfigurationHolder;
use PHPUnit\TextUI\Configuration\Loader;
use PHPUnit\Util\Configuration;

class ConfigLoader
{
    /**
     * Load configuration from file
     *
     * @param string $fileName
     * @return ConfigurationHolder
     */
    public static function loadConfig(string $fileName): ConfigurationHolder
    {
        if (class_exists(Configuration::class)) {
            $configuration = Configuration::getInstance($fileName);
            $filename = $configuration->getFilename();
            $phpunit = $configuration->getPHPUnitConfiguration();
            $bootstrap = '';
            if (isset($phpunit['bootstrap'])) {
                $bootstrap = $phpunit['bootstrap'];
            }
        } else {
            $loader = new Loader();

            $configuration = $loader->load($fileName);
            $filename = $configuration->filename();
            $phpunit = $configuration->phpunit();
            $bootstrap = $phpunit->hasBootstrap() ? $phpunit->bootstrap() : null;
        }

        return new ConfigurationHolder($configuration, $filename, $bootstrap);
    }
}
