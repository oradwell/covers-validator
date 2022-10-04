<?php

namespace OckCyp\CoversValidator\Loader;

use OckCyp\CoversValidator\Model\ConfigurationHolder;
use OckCyp\CoversValidator\Model\TestCollection;

class TestSuiteLoader
{
    /**
     * Load test suite
     */
    public static function loadSuite(ConfigurationHolder $configurationHolder): TestCollection
    {
        return new TestCollection($configurationHolder);
    }
}
