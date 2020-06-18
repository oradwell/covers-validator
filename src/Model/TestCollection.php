<?php

namespace OckCyp\CoversValidator\Model;

use PHPUnit\Util\Configuration as PHPUnit8Configuration;
use PHPUnit\TextUI\Configuration\Configuration;
use PHPUnit\TextUI\Configuration\TestSuiteMapper;
use PHPUnit\Framework\WarningTestCase;

class TestCollection implements \Countable, \Iterator
{
    /**
     * @var ConfigurationHolder
     */
    private $configurationHolder;

    /**
     * @var \Iterator
     */
    private $iterator;

    public function __construct(ConfigurationHolder $configurationHolder)
    {
        $configuration = $configurationHolder->getConfiguration();

        // echo get_class($configuration->testSuite());

        if ($configuration instanceof PHPUnit8Configuration) {
            $this->iterator = new \RecursiveIteratorIterator($configuration->getTestSuiteConfiguration());
        } else {
            $testSuiteMapper = new TestSuiteMapper();

            $testSuites = $testSuiteMapper->map($configuration->testSuite(), '');

            $this->iterator = new \RecursiveArrayIterator($testSuites);
        }
    }

    public function current()
    {
        return $this->iterator->current();
    }

    public function key()
    {
        return $this->iterator->key();
    }

    public function next()
    {
        $this->iterator->next();

        if ($this->iterator->current() instanceof WarningTestCase) {
            return $this->iterator->next();
        }
    }

    public function rewind()
    {
        $this->iterator->rewind();
    }

    public function valid(): bool
    {
        return $this->iterator->valid();
    }

    public function count()
    {
        return $this->iterator->count();
    }
}
