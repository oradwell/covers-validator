<?php

namespace OckCyp\CoversValidator\Command;

use OckCyp\CoversValidator\Loader\ConfigLoader;
use OckCyp\CoversValidator\Loader\TestSuiteLoader;
use OckCyp\CoversValidator\Locator\ConfigLocator;
use OckCyp\CoversValidator\Validator\Validator;
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
            ->addOption('configuration', 'c', InputOption::VALUE_REQUIRED, 'Read configuration from XML file.');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $configOption = $input->getOption('configuration');
        $configFile = ConfigLocator::locate($configOption);
        $configuration = ConfigLoader::loadConfig($configFile);
        $suiteList = TestSuiteLoader::loadSuite($configuration);

        if (!count($suiteList)) {
            return 0;
        }

        $allValid = true;
	    /** @var \PHPUnit_Framework_TestSuite $suite */
	    foreach ($suiteList as $suite) {
            $testClass = $suite->getName();
		    /** @var \PHPUnit_Framework_TestSuite $test */
            foreach ($suite as $test) {
                $testMethod = $test->getName();
                $isValid = Validator::isValidMethod(
                    $testClass,
                    $testMethod
                );
                // Change exit code to 1 if invalid
                $allValid = $allValid && $isValid;

                $validityText = $isValid ? 'Valid' : 'Invalid';
                $output->writeln($validityText . ' - ' . $testClass . '::' . $testMethod);
            }
        }

        // Return exit code 1 if any of the tags are invalid
        // otherwise return exit code 0
        return (int) !$allValid;
    }
}
