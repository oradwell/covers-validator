<?php

namespace OckCyp\CoversValidator\Tests;

use OckCyp\CoversValidator\ConfigDeterminer;

class ConfigDeterminerTest extends ConfigTestCase
{
    /**
     * @covers OckCyp\CoversValidator\ConfigDeterminer::determine
     */
    public function testGetsDefaultConfigPath()
    {
        touch('phpunit.xml');

        $this->assertEquals(
            realpath('phpunit.xml'),
            ConfigDeterminer::determine(null)
        );
    }

    /**
     * @covers OckCyp\CoversValidator\ConfigDeterminer::determine
     */
    public function testGetsDefaultConfigPathEvenWhenDistExists()
    {
        touch('phpunit.xml');
        touch('phpunit.xml.dist');

        $this->assertEquals(
            realpath('phpunit.xml'),
            ConfigDeterminer::determine(null)
        );
    }

    /**
     * @covers OckCyp\CoversValidator\ConfigDeterminer::determine
     */
    public function testGetsDefaultDistConfigPath()
    {
        touch('phpunit.xml.dist');

        $this->assertEquals(
            realpath('phpunit.xml.dist'),
            ConfigDeterminer::determine(null)
        );
    }

    /**
     * @covers OckCyp\CoversValidator\ConfigDeterminer::determine
     */
    public function testGetsDefaultDistConfigPathInGivenDirectory()
    {
        mkdir('some-other-dir');
        $configPath = 'some-other-dir' . DIRECTORY_SEPARATOR . 'phpunit.xml.dist';
        touch($configPath);

        $this->assertEquals(
            realpath($configPath),
            ConfigDeterminer::determine('some-other-dir')
        );
    }

    /**
     * @covers OckCyp\CoversValidator\ConfigDeterminer::determine
     */
    public function testGetsDefaultConfigpathInGivenDirectory()
    {
        mkdir('some-other-dir');
        $configPath = 'some-other-dir' . DIRECTORY_SEPARATOR . 'phpunit.xml';
        touch($configPath);

        $this->assertEquals(
            realpath($configPath),
            ConfigDeterminer::determine('some-other-dir')
        );
    }

    /**
     * @covers OckCyp\CoversValidator\ConfigDeterminer::determine
     */
    public function testGetsDefaultConfigpathInGivenDirectoryEvenWhenDistExists()
    {
        mkdir('some-other-dir');
        $configPath = 'some-other-dir' . DIRECTORY_SEPARATOR . 'phpunit.xml';
        touch($configPath);
        touch($configPath . '.dist');

        $this->assertEquals(
            realpath($configPath),
            ConfigDeterminer::determine('some-other-dir')
        );
    }

    /**
     * @covers OckCyp\CoversValidator\ConfigDeterminer::determine
     */
    public function testGetsGivenConfigFile()
    {
        mkdir('some-other-dir');
        $configPath = 'some-other-dir' . DIRECTORY_SEPARATOR . 'some-config.xml';
        touch($configPath);

        $this->assertEquals(
            realpath($configPath),
            ConfigDeterminer::determine($configPath)
        );
    }

    /**
     * @covers OckCyp\CoversValidator\ConfigDeterminer::determine
     */
    public function testReturnsNullWhenConfigFileDoesNotExist()
    {
        $this->assertNull(ConfigDeterminer::determine(null));
    }
}
