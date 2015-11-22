<?php

namespace OckCyp\CoversValidator\Application;

use OckCyp\CoversValidator\Command\ValidateCommand;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Input\InputInterface;

class CoversValidator extends Application
{
    const NAME = 'CoversValidator';
    const VERSION = '0.3';

    /**
     * {@inheritdoc}
     */
    public function __construct($name = self::NAME, $version = self::VERSION)
    {
        parent::__construct($name, $version);
    }

    /**
     * {@inheritdoc}
     */
    protected function getCommandName(InputInterface $input)
    {
        return 'validate';
    }

    /**
     * {@inheritdoc}
     */
    protected function getDefaultCommands()
    {
        $defaultCommands = parent::getDefaultCommands();
        $defaultCommands[] = new ValidateCommand;

        return $defaultCommands;
    }

    /**
     * {@inheritdoc}
     */
    public function getDefinition()
    {
        $inputDefinition = parent::getDefinition();
        $inputDefinition->setArguments();

        return $inputDefinition;
    }
}
