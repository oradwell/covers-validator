<?php

namespace OckCyp\CoversValidator\Model;

use PHPUnit\Util\Configuration as PHPUnit8Configuration;

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
            if (class_exists('PHPUnit\TextUI\Configuration\TestSuiteMapper', true)) {
                // PHPUnit < 9.3
                $testSuiteMapper = new \PHPUnit\TextUI\Configuration\TestSuiteMapper();
            } elseif (class_exists('PHPUnit\TextUI\XmlConfiguration\TestSuiteMapper', true)) {
                // PHPUnit >= 9.3 & < 9.5
                $testSuiteMapper = new \PHPUnit\TextUI\XmlConfiguration\TestSuiteMapper();
            } elseif (class_exists('PHPUnit\TextUI\TestSuiteMapper', true)) {
                // PHPUnit >= 9.5
                $testSuiteMapper = new \PHPUnit\TextUI\TestSuiteMapper();
            } else {
                throw new \RuntimeException('Could not find PHPUnit TestSuiteMapper class');
            }

            $this->iterator = $testSuiteMapper->map($configuration->testSuite(), '');
        }

        $this->iteratorIterator = new \RecursiveIteratorIterator($this->iterator);
    }

    #[\ReturnTypeWillChange]
    public function current()
    {
        return $this->iteratorIterator->current();
    }

    #[\ReturnTypeWillChange]
    public function key()
    {
        return $this->iteratorIterator->key();
    }

    #[\ReturnTypeWillChange]
    public function next()
    {
        $this->iteratorIterator->next();
    }

    #[\ReturnTypeWillChange]
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
