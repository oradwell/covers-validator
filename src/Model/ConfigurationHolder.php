<?php

namespace OckCyp\CoversValidator\Model;

use PHPUnit\TextUI\Configuration\Configuration as PHPUnit9Configuration;
use PHPUnit\TextUI\XmlConfiguration\Configuration as PHPUnit10Configuration;
use PHPUnit\Util\Configuration as PHPUnit8Configuration;

class ConfigurationHolder
{
    /**
     * @var PHPUnit8Configuration|PHPUnit9Configuration|PHPUnit10Configuration
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
     * @param PHPUnit8Configuration|PHPUnit9Configuration|PHPUnit10Configuration $configuration
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
