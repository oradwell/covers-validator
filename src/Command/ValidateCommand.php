<?php

namespace OckCyp\CoversValidator\Command;

use OckCyp\CoversValidator\Handler\InputHandler;
use OckCyp\CoversValidator\Loader\TestSuiteLoader;
use OckCyp\CoversValidator\Validator\Validator;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class ValidateCommand extends Command
{
    /**
     * @var bool
     */
    protected $firstValidityWrite = true;

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
            ->addUsage('-c app')
            ->addUsage('-c tests/configuration.xml')
            ->addOption(
                'bootstrap',
                null,
                InputOption::VALUE_REQUIRED,
                'A "bootstrap" PHP file that is run before the validation.'
            )
            ->addUsage('--bootstrap=tests/bootstrap.php');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln($this->getApplication()->getLongVersion());

        $configuration = InputHandler::handleInput($input);
        if ($output->getVerbosity() >= OutputInterface::VERBOSITY_VERY_VERBOSE) {
            $output->writeln(PHP_EOL . sprintf(
                'Configuration file loaded: %s',
                $configuration->getFilename()
            ));
        }

        $suiteList = TestSuiteLoader::loadSuite($configuration);
        if (!count($suiteList)) {
            $output->writeln(PHP_EOL . 'No tests found to validate.');
            return 0;
        }

        $failedCount = 0;
        $suiteIterator = new \RecursiveIteratorIterator($suiteList);
        /** @var \PHPUnit_Framework_TestCase $suite */
        foreach ($suiteIterator as $suite) {
            // PHPUnit 4 and PHPUnit 5 uses different classes for this
            if ($suite instanceof \PHPUnit_Framework_WarningTestCase
                || $suite instanceof \PHPUnit_Framework_Warning
            ) {
                continue;
            }

            $testClass = get_class($suite);
            $testMethod = $suite->getName(false);
            $testSignature = $testClass . '::' . $suite->getName();

            if ($output->getVerbosity() >= OutputInterface::VERBOSITY_DEBUG) {
                $this->writeValidity($output, 'Validating ' . $testSignature . '...');
            }

            $isValid = Validator::isValidMethod(
                $testClass,
                $testMethod
            );

            if (!$isValid) {
                $failedCount++;
                $this->writeValidity($output, $testSignature, false);
            } elseif ($output->getVerbosity() >= OutputInterface::VERBOSITY_VERBOSE) {
                $this->writeValidity($output, $testSignature, true);
            }
        }

        $output->writeln('');

        if ($failedCount > 0) {
            $output->writeln(
                "There were {$failedCount} test(s) with invalid @covers tags."
            );

            return 1;
        }

        $output->writeln('Validation complete. All @covers tags are valid.');

        return 0;
    }

    /**
     * Write validity message for tests
     * The purpose of this method is to write a new line for the first
     * validity related message
     *
     * @param OutputInterface $output
     * @param string $message
     * @param bool|null $isValid
     */
    protected function writeValidity($output, $message, $isValid = null) {
        if ($this->firstValidityWrite) {
            $output->writeln('');
            $this->firstValidityWrite = false;
        }

        if (is_bool($isValid)) {
            $message = sprintf(
                '%s - %s',
                $isValid ? '<fg=green>Valid</>' : '<fg=red>Invalid</>',
                $message
            );
        }

        $output->writeln($message);
    }
}
