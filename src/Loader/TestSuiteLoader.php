<?php

namespace OckCyp\CoversValidator\Loader;

use PHPUnit_Util_Configuration as Configuration;
use PHPUnit_Framework_TestSuite as TestSuite;

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
