<?php

namespace OckCyp\CoversValidator;

class ConfigDeterminer
{
    const CONFIG_FILENAME = 'phpunit.xml';

    /**
     * Determines config file to use in the way PHPUnit does it
     *
     * @param string $configOption
     * @return string|null
     */
    public static function determine($configOption)
    {
        $configurationFile = static::CONFIG_FILENAME;
        if (is_dir($configOption)) {
            $configurationFile = $configOption . DIRECTORY_SEPARATOR . $configurationFile;
        }
        if (file_exists($configOption) && is_file($configOption)) {
            return realpath($configOption);
        }
        if (file_exists($configurationFile)) {
            return realpath($configurationFile);
        }
        if (file_exists($configurationFile . '.dist')) {
            return realpath($configurationFile . '.dist');
        }

        return null;
    }
}
