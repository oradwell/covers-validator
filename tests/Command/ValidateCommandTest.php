<?php

namespace OckCyp\CoversValidator\Tests\Command;

use OckCyp\CoversValidator\Application\CoversValidator;
use OckCyp\CoversValidator\Command\ValidateCommand;
use OckCyp\CoversValidator\Tests\BaseTestCase;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\NullOutput;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Tester\CommandTester;

/**
 * Integration tests
 *
 * For some reason had to split the test files into different suites
 * PHPUnit skips the files when command is run second time
 *
 * @covers OckCyp\CoversValidator\Application\CoversValidator
 * @covers OckCyp\CoversValidator\Command\ValidateCommand
 * @covers OckCyp\CoversValidator\Model\TestCollection
 * @covers OckCyp\CoversValidator\Model\ConfigurationHolder
 */
class ValidateCommandTest extends BaseTestCase
{
    public function testPrintsConfigFileUsed()
    {
        $configFile = 'tests/Fixtures/configuration-empty.xml';

        $app = new CoversValidator;
        /** @var ValidateCommand $command */
        $command = $app->find('validate');
        $commandTester = new CommandTester($command);
        $exitCode = $commandTester->execute(
            array(
                '-c' => $configFile
            ),
            array(
                'verbosity' => OutputInterface::VERBOSITY_VERY_VERBOSE
            )
        );

        $this->assertEquals(0, $exitCode);
        $this->assertRegex(
            sprintf(
                '{Configuration file loaded: %s}',
                preg_quote(realpath($configFile))
            ),
            $commandTester->getDisplay()
        );
    }

    public function testReturnsSuccessForEmptyTestSuite()
    {
        $app = new CoversValidator;
        /** @var ValidateCommand $command */
        $command = $app->find('validate');
        $commandTester = new CommandTester($command);
        $exitCode = $commandTester->execute(array(
            '-c' => 'tests/Fixtures/configuration-empty.xml'
        ));

        $this->assertEquals(0, $exitCode);
        $this->assertRegex('/No tests found to validate./', $commandTester->getDisplay());
    }

    public function testReturnsFailForNonExistentClasses()
    {
        $app = new CoversValidator;
        /** @var ValidateCommand $command */
        $command = $app->find('validate');
        $commandTester = new CommandTester($command);
        $exitCode = $commandTester->execute(array(
            '-c' => 'tests/Fixtures/configuration-nonexistent.xml'
        ));

        $this->assertGreaterThan(0, $exitCode);
        $display = $commandTester->getDisplay();
        $this->assertRegex('/Invalid - /', $display);
        $this->assertRegex('/' . preg_quote(CoversValidator::NAME, '/') . ' (?:version )?' . preg_quote(CoversValidator::VERSION, '/') . '/', $display);
        $this->assertRegex('/There were 1 test\(s\) with invalid @covers tags./', $display);
    }

    public function testReturnsFailForEmptyCoversTag()
    {
        $app = new CoversValidator;
        /** @var ValidateCommand $command */
        $command = $app->find('validate');
        $commandTester = new CommandTester($command);
        $exitCode = $commandTester->execute(array(
            '-c' => 'tests/Fixtures/configuration-emptycovers.xml'
        ));

        $this->assertGreaterThan(0, $exitCode);
        $display = $commandTester->getDisplay();
        $this->assertRegex('/Invalid - /', $display);
        $this->assertRegex('/There were 1 test\(s\) with invalid @covers tags./', $display);
    }

    public function testReturnsFailForInvalidCoversTagWithProvider()
    {
        $app = new CoversValidator;
        /** @var ValidateCommand $command */
        $command = $app->find('validate');
        $commandTester = new CommandTester($command);
        $exitCode = $commandTester->execute(array(
            '-c' => 'tests/Fixtures/configuration-nonexistentprovider.xml'
        ));

        $this->assertGreaterThan(0, $exitCode);
        $display = $commandTester->getDisplay();
        $this->assertRegex('/Invalid - /', $display);
        $this->assertRegex('/There were 1 test\(s\) with invalid @covers tags./', $display);
    }

    public function testReturnsSuccessForExistingClasses()
    {
        $app = new CoversValidator;
        /** @var ValidateCommand $command */
        $command = $app->find('validate');
        $commandTester = new CommandTester($command);
        $exitCode = $commandTester->execute(
            array(
                '-c' => 'tests/Fixtures/configuration-existing.xml',
            ),
            array(
                'verbosity' => OutputInterface::VERBOSITY_DEBUG
            )
        );

        $this->assertEquals(0, $exitCode);
        $display = $commandTester->getDisplay();
        $this->assertRegex('/Valid - /', $display);
        $this->assertRegex('/Validating /', $display);
    }

    public function testReturnsSuccessForValidCoversTagWithProvider()
    {
        $app = new CoversValidator;
        /** @var ValidateCommand $command */
        $command = $app->find('validate');
        $commandTester = new CommandTester($command);
        $exitCode = $commandTester->execute(array(
            '-c' => 'tests/Fixtures/configuration-existingprovider.xml'
        ));

        $this->assertSame(0, $exitCode);
        $display = $commandTester->getDisplay();
        $this->assertRegex('/Validation complete. All @covers tags are valid./', $display);
    }

    public function testReturnsFailForComboClasses()
    {
        $app = new CoversValidator;
        /** @var ValidateCommand $command */
        $command = $app->find('validate');
        $commandTester = new CommandTester($command);
        $exitCode = $commandTester->execute(array(
            '-c' => 'tests/Fixtures/configuration-all.xml'
        ));

        $this->assertGreaterThan(0, $exitCode);
        $display = $commandTester->getDisplay();
        $this->assertRegex('/Invalid - /', $display);
        $this->assertRegex('/There were 1 test\(s\) with invalid @covers tags./', $display);
    }

    public function testSkipsEmptyTestClasses()
    {
        $app = new CoversValidator;
        /** @var ValidateCommand $command */
        $command = $app->find('validate');
        $commandTester = new CommandTester($command);
        $exitCode = $commandTester->execute(
            array(
                '-c' => 'tests/Fixtures/configuration-multi-testsuite.xml'
            ),
            array(
                'verbosity' => OutputInterface::VERBOSITY_DEBUG
            )
        );

        $this->assertEquals(0, $exitCode);
        $display = $commandTester->getDisplay();
        // Generated by PHPUnit 6
        $this->assertNotRegex('/PHPUnit\\\\Framework\\\\WarningTestCase::Warning/', $display);
        $this->assertRegex('/Validation complete\. All @covers tags are valid\./', $display);
    }

    public function testApplicationHasDefaultCommand()
    {
        $input = new ArrayInput(array(
            '-c' => 'tests/Fixtures/configuration-empty.xml'
        ));

        $app = new CoversValidator;
        $exitCode = $app->doRun($input, new NullOutput);

        $this->assertEquals(0, $exitCode);
    }

    public function testBootstrapOptionWorks()
    {
        $input = new ArrayInput(array(
            '-c' => 'tests/Fixtures/configuration-empty.xml',
            '--bootstrap' => 'tests/Fixtures/bootstrap-3.php',
        ));

        $app = new CoversValidator;
        $exitCode = $app->doRun($input, new NullOutput);

        $this->assertEquals(0, $exitCode);
    }
}
