<?php

namespace OckCyp\CoversValidator\Application;

use Composer\InstalledVersions;
use OckCyp\CoversValidator\Command\ValidateCommand;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Input\InputInterface;

if (version_compare(InstalledVersions::getVersion('symfony/console'), '6.0.0') >= 0) {
    class CoversValidator extends Application
    {
        const NAME = 'CoversValidator';
        const VERSION = '1.4.0';

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
            $defaultCommands[] = new ValidateCommand;

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
} else {
    class CoversValidator extends Application
    {
        const NAME = 'CoversValidator';
        const VERSION = '1.4.0';

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
}
