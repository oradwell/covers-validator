<?php

namespace OckCyp\CoversValidator\Tests;

use PHPUnit\Framework\TestCase;

abstract class BaseTestCase extends TestCase
{
    const FIXTURE_NS_PREFIX = 'OckCyp\CoversValidator\Tests\Fixtures\\';

    /**
     * Returns the namespace of fixture class
     *
     * @param string $class
     *
     * @return string
     */
    protected function getFixtureClassName($class)
    {
        return static::FIXTURE_NS_PREFIX . $class;
    }
}
