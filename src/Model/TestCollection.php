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

    /**
     * @var \Iterator
     */
    private $iteratorIterator;

    public function __construct(ConfigurationHolder $configurationHolder)
    {
        $configuration = $configurationHolder->getConfiguration();

        if ($configuration instanceof PHPUnit8Configuration) {
            $this->iterator = $configuration->getTestSuiteConfiguration();
        } else {
            $testSuiteMapper = new TestSuiteMapper();

            $this->iterator = $testSuiteMapper->map($configuration->testSuite(), '');
        }

        $this->iteratorIterator = new \RecursiveIteratorIterator($this->iterator);
    }

    public function current()
    {
        return $this->iteratorIterator->current();
    }

    public function key()
    {
        return $this->iteratorIterator->key();
    }

    public function next()
    {
        $this->iteratorIterator->next();
    }

    public function rewind()
    {
        $this->iteratorIterator->rewind();
    }

    public function valid(): bool
    {
        return $this->iteratorIterator->valid();
    }

    public function isEmpty(): bool
    {
        return !\count($this->iterator);
    }
}
