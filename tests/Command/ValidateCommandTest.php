<?php

namespace OckCyp\CoversValidator\Tests\Command;

use OckCyp\CoversValidator\Application\CoversValidator;
use OckCyp\CoversValidator\Command\ValidateCommand;
use OckCyp\CoversValidator\Tests\BaseTestCase;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\NullOutput;
use Symfony\Component\Console\Tester\CommandTester;

/**
 * Integration tests
 *
 * For some reason had to split the test files into different suites
 * PHPUnit skips the files when command is run second time
 *
 * @covers OckCyp\CoversValidator\Application\CoversValidator
 * @covers OckCyp\CoversValidator\Command\ValidateCommand
 */
class ValidateCommandTest extends BaseTestCase
{
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
        $this->assertRegExp('/Invalid/', $commandTester->getDisplay());
    }

    public function testReturnsSuccessForExistingClasses()
    {
        $app = new CoversValidator;
        /** @var ValidateCommand $command */
        $command = $app->find('validate');
        $commandTester = new CommandTester($command);
        $exitCode = $commandTester->execute(array(
            '-c' => 'tests/Fixtures/configuration-existing.xml'
        ));

        $this->assertEquals(0, $exitCode);
        $this->assertRegExp('/Valid/', $commandTester->getDisplay());
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
        $this->assertRegExp('/Invalid/', $commandTester->getDisplay());
        $this->assertRegExp('/Valid/', $commandTester->getDisplay());
    }

    public function testSkipsEmptyTestClasses()
    {
        $app = new CoversValidator;
        /** @var ValidateCommand $command */
        $command = $app->find('validate');
        $commandTester = new CommandTester($command);
        $exitCode = $commandTester->execute(array(
            '-c' => 'tests/Fixtures/configuration-multi-testsuite.xml'
        ));

        $this->assertEquals(0, $exitCode);
        $this->assertNotRegExp('/PHPUnit_Framework_Warning::Warning/', $commandTester->getDisplay());
        $this->assertRegExp('/Valid/', $commandTester->getDisplay());
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
