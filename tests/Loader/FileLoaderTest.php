<?php

namespace OckCyp\CoversValidator\Tests\Loader;

use OckCyp\CoversValidator\Loader\FileLoader;
use OckCyp\CoversValidator\Tests\FileTestCase;

class FileLoaderTest extends FileTestCase
{
    /**
     * @covers \OckCyp\CoversValidator\Loader\FileLoader::loadFile
     */
    public function testLoadsFile()
    {
        file_put_contents('my1.php', '<?php $cv_global_var = true;');
        FileLoader::loadFile('my1.php');
        $this->assertTrue(isset($GLOBALS['cv_global_var']));
    }

    /**
     * @covers \OckCyp\CoversValidator\Loader\FileLoader::loadFile
     */
    public function testLoadsFile2()
    {
        file_put_contents('my2.php', '<?php $cv_global_var = true;');
        FileLoader::loadFile('my2.php');
        $this->assertTrue(isset($GLOBALS['cv_global_var']));
    }
}
