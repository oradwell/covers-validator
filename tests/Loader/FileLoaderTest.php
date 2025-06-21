<?php

namespace OckCyp\CoversValidator\Tests\Loader;

use OckCyp\CoversValidator\Loader\FileLoader;
use OckCyp\CoversValidator\Tests\FileTestCase;
use PHPUnit\Runner\Version;

class FileLoaderTest extends FileTestCase
{
    /**
     * @covers \OckCyp\CoversValidator\Loader\FileLoader::loadFile
     */
    public function testLoadsFileWithVar()
    {
        // NOTE: Version::majorVersionNumber exists in PHPUnit 10+ only
        if ((int) Version::series() >= 10) {
            $this->markTestSkipped('Only for PHPUnit 9 and below');

            return;
        }

        file_put_contents('myvar1.php', '<?php $cv_global_var = true;');
        FileLoader::loadFile('myvar1.php');
        $this->assertTrue(isset($GLOBALS['cv_global_var']));
    }

    /**
     * @covers \OckCyp\CoversValidator\Loader\FileLoader::loadFile
     */
    public function testLoadsFileWithVar2()
    {
        if ((int) Version::series() >= 10) {
            $this->markTestSkipped('Only for PHPUnit 9 and below');

            return;
        }

        file_put_contents('myvar2.php', '<?php $cv_global_var = true;');
        FileLoader::loadFile('myvar2.php');
        $this->assertTrue(isset($GLOBALS['cv_global_var']));
    }

    /**
     * @covers \OckCyp\CoversValidator\Loader\FileLoader::loadFile
     */
    public function testLoadsFileWithFunc()
    {
        file_put_contents('myfunc.php', '<?php function ockcyp_covers_valid_example() {}');
        FileLoader::loadFile('myfunc.php');
        $this->assertTrue(function_exists('ockcyp_covers_valid_example'));
    }
}
