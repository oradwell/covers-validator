<?php

namespace OckCyp\CoversValidator\Application;

use OckCyp\CoversValidator\Command\ValidateCommand;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Input\InputInterface;

class CoversValidator extends Application
{
    public const NAME = 'CoversValidator';
    public const VERSION = '1.5.0';

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
    protected function getCommandName(InputInterface $input): ?string
    {
        return 'validate';
    }

    /**
     * {@inheritdoc}
     */
    protected function getDefaultCommands(): array
    {
        $defaultCommands = parent::getDefaultCommands();
        $defaultCommands[] = new ValidateCommand();

        return $defaultCommands;
    }

    /**
     * {@inheritdoc}
     */
    public function getDefinition(): InputDefinition
    {
        $inputDefinition = parent::getDefinition();
        $inputDefinition->setArguments();

        return $inputDefinition;
    }
}
