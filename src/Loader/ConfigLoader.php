<?php

namespace OckCyp\CoversValidator\Loader;

use OckCyp\CoversValidator\Model\ConfigurationHolder;
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
            // PHPUnit < 9.3
            if (class_exists('PHPUnit\TextUI\Configuration\Loader', true)) {
                $loader = new \PHPUnit\TextUI\Configuration\Loader();
            }
            // PHPUnit >= 9.3
            elseif (class_exists('PHPUnit\TextUI\XmlConfiguration\Loader', true)) {
                $loader = new \PHPUnit\TextUI\XmlConfiguration\Loader();
            } else {
                throw new \RuntimeException('Could not find PHPUnit\'s configuration loader class.');
            }

            $configuration = $loader->load($fileName);
            $filename = $configuration->filename();
            $phpunit = $configuration->phpunit();
            $bootstrap = $phpunit->hasBootstrap() ? $phpunit->bootstrap() : null;
        }

        return new ConfigurationHolder($configuration, $filename, $bootstrap);
    }
}
