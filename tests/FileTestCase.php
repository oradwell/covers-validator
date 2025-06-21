<?php

namespace OckCyp\CoversValidator\Tests;

abstract class FileTestCase extends BaseTestCase
{
    /** @var string */
    private $runDir;
    /** @var string */
    private $tmpDir;

    protected function setUp(): void
    {
        $this->runDir = getcwd();
        $this->tmpDir = sys_get_temp_dir().DIRECTORY_SEPARATOR.'covers-validator';
        mkdir($this->tmpDir);
        chdir($this->tmpDir);
    }

    protected function tearDown(): void
    {
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

            $path = $directory.DIRECTORY_SEPARATOR.$filename;
            if (is_dir($path)) {
                self::recursiveRmDir($path);
                continue;
            }

            unlink($path);
        }

        rmdir($directory);
    }
}
