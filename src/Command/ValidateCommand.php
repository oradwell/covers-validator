<?php

namespace OckCyp\CoversValidator\Command;

use OckCyp\CoversValidator\ConfigDeterminer;
use OckCyp\CoversValidator\ConfigLoader;
use OckCyp\CoversValidator\TestSuiteLoader;
use OckCyp\CoversValidator\Validator;
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
        $configFile = ConfigDeterminer::determine($configOption);
        $configuration = ConfigLoader::loadConfig($configFile);
        $suiteList = TestSuiteLoader::loadSuite($configuration);

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

                $validityText = $isValid ? 'Valid' : 'Invalid';
                $output->writeln($validityText . ' - ' . $testClass . '::' . $testMethod);
            }
        }
    }
}
