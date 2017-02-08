<?php

namespace OckCyp\CoversValidator\Handler;

use OckCyp\CoversValidator\Loader\ConfigLoader;
use OckCyp\CoversValidator\Loader\FileLoader;
use OckCyp\CoversValidator\Locator\ConfigLocator;
use PHPUnit\Util\Configuration;
use Symfony\Component\Console\Input\InputInterface;

class InputHandler
{
    /**
     * Handle console input
     *
     * @param InputInterface $input
     * @return Configuration
     */
    public static function handleInput(InputInterface $input)
    {
        $configOption = $input->getOption('configuration');
        $configFile = ConfigLocator::locate($configOption);
        $configuration = ConfigLoader::loadConfig($configFile);

        $phpunit = $configuration->getPHPUnitConfiguration();
        if (null !== $input->getOption('bootstrap')) {
            $phpunit['bootstrap'] = $input->getOption('bootstrap');
        }

        if (isset($phpunit['bootstrap'])) {
            FileLoader::loadFile($phpunit['bootstrap']);
        }

        return $configuration;
    }
}
