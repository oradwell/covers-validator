<?php

namespace OckCyp\CoversValidator\Tests;

use PHPUnit\Framework\TestCase;

abstract class BaseTestCase extends TestCase
{
    public const FIXTURE_NS_PREFIX = 'OckCyp\CoversValidator\Tests\Fixtures\\';

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
