<?php

namespace OckCyp\CoversValidator\Loader;

use PHPUnit_Framework_TestSuite as TestSuite;
use PHPUnit_Util_Configuration as Configuration;

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
