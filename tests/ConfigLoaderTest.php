<?php

namespace OckCyp\CoversValidator\Tests;

use OckCyp\CoversValidator\ConfigLoader;

class ConfigLoaderTest extends ConfigTestCase
{
    /**
     * @covers OckCyp\CoversValidator\ConfigLoader::loadConfig
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
