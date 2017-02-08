<?php

namespace OckCyp\CoversValidator\Loader;

use PHPUnit\Framework\TestSuite;
use PHPUnit\Util\Configuration;

class TestSuiteLoader
{
    /**
     * Load test suite
     *
     * @param Configuration $configuration
     * @return TestSuite
     */
    public static function loadSuite(Configuration $configuration)
    {
        return $configuration->getTestSuiteConfiguration();
    }
}
