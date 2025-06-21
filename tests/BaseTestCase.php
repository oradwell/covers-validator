<?php

namespace OckCyp\CoversValidator\Tests;

use PHPUnit\Framework\TestCase;
use PHPUnit\Runner\Version;
use PHPUnit\TextUI\Configuration\Registry as ConfigurationRegistry;
use ReflectionClass;

abstract class BaseTestCase extends TestCase
{
    public const FIXTURE_NS_PREFIX = 'OckCyp\CoversValidator\Tests\Fixtures\\';

    private $configRegistryInstance = null;

    /**
     * @before
     */
    protected function savePHPUnitState()
    {
        // Manipulated by TestSuiteLoader::loadSuite/TestCollection for PHPUnit 10+
        if (class_exists(ConfigurationRegistry::class) && (int) Version::series() >= 10) {
            $class = new ReflectionClass(ConfigurationRegistry::class);
            $this->configRegistryInstance = $class->getProperty('instance')->getValue();
        }
    }

    /**
     * @after
     */
    protected function restorePHPUnitState()
    {
        if ($this->configRegistryInstance) {
            $class = new ReflectionClass(ConfigurationRegistry::class);
            $class->getProperty('instance')->setValue(null, $this->configRegistryInstance);
            $this->configRegistryInstance = null;
        }
    }

    /**
     * Returns the namespace of fixture class
     *
     * @param string $class
     *
     * @return string
     */
    protected function getFixtureClassName($class)
    {
        return static::FIXTURE_NS_PREFIX.$class;
    }

    protected function assertRegex(string $pattern, string $string, string $message = '')
    {
        if (method_exists($this, 'assertMatchesRegularExpression')) {
            return $this->assertMatchesRegularExpression($pattern, $string, $message);
        }

        return $this->assertRegExp($pattern, $string, $message);
    }

    protected function assertNotRegex(string $pattern, string $string, string $message = '')
    {
        if (method_exists($this, 'assertMatchesRegularExpression')) {
            return $this->assertDoesNotMatchRegularExpression($pattern, $string, $message);
        }

        return $this->assertNotRegExp($pattern, $string, $message);
    }
}
