<?php

namespace OckCyp\CoversValidator\Tests\Locator;

use OckCyp\CoversValidator\Locator\ConfigLocator;
use OckCyp\CoversValidator\Tests\FileTestCase;

class ConfigLocatorTest extends FileTestCase
{
    /**
     * @covers OckCyp\CoversValidator\Locator\ConfigLocator::locate
     */
    public function testGetsDefaultConfigPath()
    {
        touch('phpunit.xml');

        $this->assertEquals(
            realpath('phpunit.xml'),
            ConfigLocator::locate(null)
        );
    }

    /**
     * @covers OckCyp\CoversValidator\Locator\ConfigLocator::locate
     */
    public function testGetsDefaultConfigPathEvenWhenDistExists()
    {
        touch('phpunit.xml');
        touch('phpunit.xml.dist');

        $this->assertEquals(
            realpath('phpunit.xml'),
            ConfigLocator::locate(null)
        );
    }

    /**
     * @covers OckCyp\CoversValidator\Locator\ConfigLocator::locate
     */
    public function testGetsDefaultDistConfigPath()
    {
        touch('phpunit.xml.dist');

        $this->assertEquals(
            realpath('phpunit.xml.dist'),
            ConfigLocator::locate(null)
        );
    }

    /**
     * @covers OckCyp\CoversValidator\Locator\ConfigLocator::locate
     */
    public function testGetsDefaultDistConfigPathInGivenDirectory()
    {
        mkdir('some-other-dir');
        $configPath = 'some-other-dir' . DIRECTORY_SEPARATOR . 'phpunit.xml.dist';
        touch($configPath);

        $this->assertEquals(
            realpath($configPath),
            ConfigLocator::locate('some-other-dir')
        );
    }

    /**
     * @covers OckCyp\CoversValidator\Locator\ConfigLocator::locate
     */
    public function testGetsDefaultConfigpathInGivenDirectory()
    {
        mkdir('some-other-dir');
        $configPath = 'some-other-dir' . DIRECTORY_SEPARATOR . 'phpunit.xml';
        touch($configPath);

        $this->assertEquals(
            realpath($configPath),
            ConfigLocator::locate('some-other-dir')
        );
    }

    /**
     * @covers OckCyp\CoversValidator\Locator\ConfigLocator::locate
     */
    public function testGetsDefaultConfigpathInGivenDirectoryEvenWhenDistExists()
    {
        mkdir('some-other-dir');
        $configPath = 'some-other-dir' . DIRECTORY_SEPARATOR . 'phpunit.xml';
        touch($configPath);
        touch($configPath . '.dist');

        $this->assertEquals(
            realpath($configPath),
            ConfigLocator::locate('some-other-dir')
        );
    }

    /**
     * @covers OckCyp\CoversValidator\Locator\ConfigLocator::locate
     */
    public function testGetsGivenConfigFile()
    {
        mkdir('some-other-dir');
        $configPath = 'some-other-dir' . DIRECTORY_SEPARATOR . 'some-config.xml';
        touch($configPath);

        $this->assertEquals(
            realpath($configPath),
            ConfigLocator::locate($configPath)
        );
    }

    /**
     * @covers OckCyp\CoversValidator\Locator\ConfigLocator::locate
     */
    public function testReturnsNullWhenConfigFileDoesNotExist()
    {
        $this->assertNull(ConfigLocator::locate(null));
    }
}
