<?php

namespace OckCyp\CoversValidator\Locator;

class ConfigLocator
{
    public const CONFIG_FILENAME = 'phpunit.xml';

    /**
     * Locates config file to use in the way PHPUnit does it
     *
     * @param string $configOption
     *
     * @return string|null
     */
    public static function locate($configOption)
    {
        if (is_null($configOption)) {
            $configOption = '';
        }

        $configurationFile = static::CONFIG_FILENAME;
        if (is_dir($configOption)) {
            $configurationFile = $configOption.DIRECTORY_SEPARATOR.$configurationFile;
        }
        if (file_exists($configOption) && is_file($configOption)) {
            return realpath($configOption);
        }
        if (file_exists($configurationFile)) {
            return realpath($configurationFile);
        }
        if (file_exists($configurationFile.'.dist')) {
            return realpath($configurationFile.'.dist');
        }

        return null;
    }
}
