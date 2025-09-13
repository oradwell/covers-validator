<?php

namespace OckCyp\CoversValidator\Model;

use PHPUnit\Runner\Version;
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

        // @codeCoverageIgnoreStart
        if ((int) Version::series() < 10) {
            if ($configuration instanceof PHPUnit8Configuration) {
                $this->iterator = $configuration->getTestSuiteConfiguration();
            } elseif (class_exists('PHPUnit\TextUI\Configuration\TestSuiteMapper')) {
                // PHPUnit < 9.3
                $testSuiteMapper = new \PHPUnit\TextUI\Configuration\TestSuiteMapper();
                $this->iterator = $testSuiteMapper->map($configuration->testSuite(), '');
            } elseif (class_exists('PHPUnit\TextUI\XmlConfiguration\TestSuiteMapper')) {
                // PHPUnit 9.3, 9.4
                $testSuiteMapper = new \PHPUnit\TextUI\XmlConfiguration\TestSuiteMapper();
                $this->iterator = $testSuiteMapper->map($configuration->testSuite(), '');
            } elseif (class_exists('PHPUnit\TextUI\TestSuiteMapper')) {
                // PHPUnit 9.5, 9.6
                $testSuiteMapper = new \PHPUnit\TextUI\TestSuiteMapper();
                $this->iterator = $testSuiteMapper->map($configuration->testSuite(), '');
            }
        // @codeCoverageIgnoreEnd
        } else {
            // PHPUnit >= 10.0: same name as PHPUnit 9.3, but map() takes different args.
            if (class_exists('PHPUnit\TextUI\XmlConfiguration\TestSuiteMapper')) {
                $testSuiteMapper = new \PHPUnit\TextUI\XmlConfiguration\TestSuiteMapper();

                // TestSuiteMapper eventually calls TestBuilder->configureTestCase,
                // which requires the ConfigurationRegistry singleton to be populated.
                \PHPUnit\TextUI\Configuration\Registry::init(
                    (new \PHPUnit\TextUI\CliArguments\Builder())->fromParameters([]),
                    $configuration
                );
                $this->iterator = $testSuiteMapper->map($configurationHolder->getFilename(), $configuration->testSuite(), '', '');
            }
        }

        if (!$this->iterator) {
            throw new \RuntimeException('Could not find PHPUnit TestSuiteMapper class'); // @codeCoverageIgnore
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

    public function next(): void
    {
        $this->iteratorIterator->next();
    }

    public function rewind(): void
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
