<?php

namespace OckCyp\CoversValidator\Handler;

use OckCyp\CoversValidator\Loader\ConfigLoader;
use OckCyp\CoversValidator\Loader\FileLoader;
use OckCyp\CoversValidator\Locator\ConfigLocator;
use OckCyp\CoversValidator\Model\ConfigurationHolder;
use Symfony\Component\Console\Input\InputInterface;

class InputHandler
{
    /**
     * Handle console input
     *
     * @param InputInterface $input
     * @return ConfigurationHolder
     */
    public static function handleInput(InputInterface $input)
    {
        $configOption = $input->getOption('configuration');
        $configFile = ConfigLocator::locate($configOption);
        $configurationHolder = ConfigLoader::loadConfig($configFile);

        $bootstrap = $configurationHolder->getBootstrap();
        if (null !== $input->getOption('bootstrap')) {
            $bootstrap = $input->getOption('bootstrap');
        }

        if (isset($bootstrap)) {
            FileLoader::loadFile($bootstrap);
        }

        return $configurationHolder;
    }
}
