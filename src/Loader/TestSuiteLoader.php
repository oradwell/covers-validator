<?php

namespace OckCyp\CoversValidator\Loader;

use OckCyp\CoversValidator\Model\ConfigurationHolder;
use OckCyp\CoversValidator\Model\TestCollection;

class TestSuiteLoader
{
    /**
     * Load test suite
     *
     * @param ConfigurationHolder $configurationHolder
     * @return TestCollection
     */
    public static function loadSuite(ConfigurationHolder $configurationHolder): TestCollection
    {
        return new TestCollection($configurationHolder);
    }
}
