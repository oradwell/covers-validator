<?php

namespace OckCyp\CoversValidator;

use OckCyp\CoversValidator\Command\ValidateCommand;
use Symfony\Component\Console\Application;

class CoversValidatorApplication extends Application
{
    /**
     * {@inheritdoc}
     */
    protected function getCommandName()
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
