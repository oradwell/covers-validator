<?php

namespace OckCyp\CoversValidator\Tests;

// Keep PHP 7.0 support whilst allowing PHPUnit 8.0 support
if (version_compare(PHP_VERSION, '7.1.0') >= 0) {
    class_alias('OckCyp\CoversValidator\Tests\FileTestCase71', 'OckCyp\CoversValidator\Tests\BaseFileTestCase');
} else {
    class_alias('OckCyp\CoversValidator\Tests\FileTestCase70', 'OckCyp\CoversValidator\Tests\BaseFileTestCase');
}

abstract class FileTestCase extends BaseFileTestCase
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
     * Run before each test. Called by TestCase::setUp
     */
    protected function preTestRun()
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
     * Run after each test. Called by TestCase::tearDown
     */
    protected function postTestRun()
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
