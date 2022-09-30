<?php

namespace OckCyp\CoversValidator\Loader;

use OckCyp\CoversValidator\Model\ConfigurationHolder;
use PHPUnit\Util\Configuration;

class ConfigLoader
{
    /**
     * Load configuration from file
     */
    public static function loadConfig(string $fileName): ConfigurationHolder
    {
        if (class_exists(Configuration::class)) {
            // @codeCoverageIgnoreStart
            $configuration = Configuration::getInstance($fileName);
            $filename = $configuration->getFilename();
            $phpunit = $configuration->getPHPUnitConfiguration();
            $bootstrap = '';
            if (isset($phpunit['bootstrap'])) {
                $bootstrap = $phpunit['bootstrap'];
            }
        // @codeCoverageIgnoreEnd
        } else {
            if (class_exists('PHPUnit\TextUI\Configuration\Loader', true)) {
                // PHPUnit < 9.3
                $loader = new \PHPUnit\TextUI\Configuration\Loader();
            } elseif (class_exists('PHPUnit\TextUI\XmlConfiguration\Loader', true)) {
                // PHPUnit >= 9.3
                $loader = new \PHPUnit\TextUI\XmlConfiguration\Loader();
            } else {
                throw new \RuntimeException('Could not find PHPUnit configuration loader class');
            }

            $configuration = $loader->load($fileName);
            $filename = $configuration->filename();
            $phpunit = $configuration->phpunit();
            $bootstrap = $phpunit->hasBootstrap() ? $phpunit->bootstrap() : null;
        }

        return new ConfigurationHolder($configuration, $filename, $bootstrap);
    }
}
