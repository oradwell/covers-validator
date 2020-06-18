<?php

namespace OckCyp\CoversValidator\Model;

use PHPUnit\Util\Configuration as PHPUnit8Configuration;
use PHPUnit\TextUI\Configuration\Configuration;

class ConfigurationHolder
{
    /**
     * @var PHPUnit8Configuration|Configuration
     */
    private $configuration;

    /**
     * @var string
     */
    private $filename;

    /**
     * @var string|null
     */
    private $bootstrap;

    /**
     * @param PHPUnit8Configuration|Configuration $configuration
     * @param string $filename
     * @param string|null $bootstrap
     */
    public function __construct($configuration, string $filename, $bootstrap)
    {
        $this->configuration = $configuration;
        $this->filename = $filename;
        $this->bootstrap = $bootstrap;
    }

    public function getFilename(): string
    {
        return $this->filename;
    }

    public function getConfiguration()
    {
        return $this->configuration;
    }

    public function getBootstrap()
    {
        return $this->bootstrap;
    }
}
