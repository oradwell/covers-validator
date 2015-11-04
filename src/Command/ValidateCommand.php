<?php

namespace OckCyp\CoversValidator\Command;

use OckCyp\CoversValidator\Loader\TestSuiteLoader;
use OckCyp\CoversValidator\Validator\Validator;
use OckCyp\CoversValidator\Handler\InputHandler;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class ValidateCommand extends Command
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setName('validate')
            ->addOption(
                'configuration',
                'c',
                InputOption::VALUE_REQUIRED,
                'Read PHPUnit configuration from XML file.'
            )
            ->addOption(
                'bootstrap',
                null,
                InputOption::VALUE_REQUIRED,
                'A "bootstrap" PHP file that is run before the validation.'
            );
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $configuration = InputHandler::handleInput($input);
        $suiteList = TestSuiteLoader::loadSuite($configuration);

        if (!count($suiteList)) {
            $output->writeln('No tests found to validate.');
            return 0;
        }

        $allValid = true;
        $suiteIterator = new \RecursiveIteratorIterator($suiteList);
        /** @var \PHPUnit_Framework_TestCase $suite */
        foreach ($suiteIterator as $suite) {
            if ($suite instanceof \PHPUnit_Framework_Warning) {
                continue;
            }

            $testClass = get_class($suite);
            $testMethod = $suite->getName();
            $isValid = Validator::isValidMethod(
                $testClass,
                $testMethod
            );

            // Change exit code to 1 if invalid
            $allValid = $allValid && $isValid;

            $validityText = $isValid ? 'Valid' : 'Invalid';
            $output->writeln($validityText . ' - ' . $testClass . '::' . $testMethod);
        }

        // Return exit code 1 if any of the tags are invalid
        // otherwise return exit code 0
        return (int) !$allValid;
    }
}
