<?php

namespace OckCyp\CoversValidator\Model;

use PHPUnit\Util\Configuration as PHPUnit8Configuration;
use PHPUnit\TextUI\Configuration\TestSuiteMapper;

class TestCollection implements \Iterator
{
    /**
     * @var \Iterator
     */
    private $iterator;

    public function __construct(ConfigurationHolder $configurationHolder)
    {
        $configuration = $configurationHolder->getConfiguration();

        if ($configuration instanceof PHPUnit8Configuration) {
            $iterator = $configuration->getTestSuiteConfiguration();
        } else {
            $testSuiteMapper = new TestSuiteMapper();

            $iterator = $testSuiteMapper->map($configuration->testSuite(), '');
        }

        $this->iterator = new \RecursiveIteratorIterator($iterator);
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
    }

    public function rewind()
    {
        $this->iterator->rewind();
    }

    public function valid(): bool
    {
        return $this->iterator->valid();
    }

    public function isEmpty(): bool
    {
        return !$this->iterator->valid() || !$this->iterator->hasChildren();
    }
}
