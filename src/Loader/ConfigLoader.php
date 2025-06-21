<?php

namespace OckCyp\CoversValidator\Loader;

use OckCyp\CoversValidator\Model\ConfigurationHolder;
use PHPUnit\Runner\Version;
use PHPUnit\TextUI\Configuration\Loader as PHPUnit9ConfigurationLoader;
use PHPUnit\TextUI\XmlConfiguration\Loader as PHPUnit10ConfigurationLoader;
use PHPUnit\Util\Configuration as PHPUnit8Configuration;

class ConfigLoader
{
    /**
     * Load configuration from file
     */
    public static function loadConfig(string $fileName): ConfigurationHolder
    {
        if ((int) Version::series() <= 8 && class_exists(PHPUnit8Configuration::class)) {
            // @codeCoverageIgnoreStart
            // PHPUnit 8.x
            $configuration = PHPUnit8Configuration::getInstance($fileName);
            $filename = $configuration->getFilename();
            $phpunit = $configuration->getPHPUnitConfiguration();
            $bootstrap = '';
            if (isset($phpunit['bootstrap'])) {
                $bootstrap = $phpunit['bootstrap'];
            }
        } else {
            if (class_exists(PHPUnit9ConfigurationLoader::class)) {
                // PHPUnit < 9.3
                $loader = new PHPUnit9ConfigurationLoader();
            // @codeCoverageIgnoreEnd
            } elseif (class_exists(PHPUnit10ConfigurationLoader::class)) {
                // PHPUnit >= 9.3
                $loader = new PHPUnit10ConfigurationLoader();
            } else {
                throw new \RuntimeException('Could not find PHPUnit configuration loader class'); // @codeCoverageIgnore
            }

            $configuration = $loader->load($fileName);
            $filename = $configuration->filename();
            $phpunit = $configuration->phpunit();
            $bootstrap = $phpunit->hasBootstrap() ? $phpunit->bootstrap() : null;
        }

        return new ConfigurationHolder($configuration, $filename, $bootstrap);
    }
}
