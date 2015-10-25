<?php

namespace OckCyp\CoversValidator\Tests\Loader;

use OckCyp\CoversValidator\Loader\ConfigLoader;
use OckCyp\CoversValidator\Tests\ConfigTestCase;

class ConfigLoaderTest extends ConfigTestCase
{
    /**
     * @covers OckCyp\CoversValidator\Loader\ConfigLoader::loadConfig
     */
    public function testLoadsConfig()
    {
        $xml = new \SimpleXMLElement('<?xml version="1.0" standalone="yes" ?><phpunit />');
        file_put_contents('temp-config.xml', $xml->asXML());

        $this->assertInstanceOf(
            'PHPUnit_Util_Configuration',
            ConfigLoader::loadConfig('temp-config.xml')
        );
    }
}
