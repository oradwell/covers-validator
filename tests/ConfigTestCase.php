<?php

namespace OckCyp\CoversValidator\Tests;

abstract class ConfigTestCase extends BaseTestCase
{
    /**
     * @var string
     */
    private $tmpDir;

    /**
     * @var string
     */
    private $runDir;

    /**
     * {@inheritdoc}
     */
    public function setUp()
    {
        // Save the original directory
        $this->runDir = getcwd();

        $this->tmpDir = sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'covers-validator';
        // Create a temp directory
        mkdir($this->tmpDir);
        // Change to the temp directory
        chdir($this->tmpDir);
    }

    /**
     * {@inheritdoc}
     */
    public function tearDown()
    {
        // Return back to original directory
        chdir($this->runDir);
        // Delete the temp directory
        self::recursiveRmDir($this->tmpDir);
    }

    /**
     * Recursively deletes a directory
     *
     * @param string $directory
     */
    private static function recursiveRmDir($directory)
    {
        foreach (scandir($directory) as $filename) {
            if ('.' === $filename || '..' === $filename) {
                continue;
            }

            $path = $directory . DIRECTORY_SEPARATOR . $filename;
            if (is_dir($path)) {
                self::recursiveRmDir($path);
                continue;
            }

            unlink($path);
        }

        rmdir($directory);
    }
}
