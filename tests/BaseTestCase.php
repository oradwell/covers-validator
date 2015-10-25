<?php

namespace OckCyp\CoversValidator\Tests;

abstract class BaseTestCase extends \PHPUnit_Framework_TestCase
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
