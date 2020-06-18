<?php

namespace OckCyp\CoversValidator\Loader;

use OckCyp\CoversValidator\Model\ConfigurationHolder;
use OckCyp\CoversValidator\Model\TestCollection;
use PHPUnit\Framework\TestSuite;
use PHPUnit\Util\Configuration;

class TestSuiteLoader
{
    /**
     * Load test suite
     *
     * @param Configuration $configurationHolder
     * @return TestCollection
     */
    public static function loadSuite(ConfigurationHolder $configurationHolder): TestCollection
    {
        return new TestCollection($configurationHolder);
    }
}
