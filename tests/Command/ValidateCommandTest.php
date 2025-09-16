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
 * @covers \OckCyp\CoversValidator\Application\CoversValidator
 * @covers \OckCyp\CoversValidator\Command\ValidateCommand
 * @covers \OckCyp\CoversValidator\Model\TestCollection
 * @covers \OckCyp\CoversValidator\Model\ConfigurationHolder
 */
class ValidateCommandTest extends BaseTestCase
{
    public static function provideIntegration()
    {
        return [
            'PrintsConfigFileUsed' => [
                'tests/Fixtures/configuration-empty.xml',
                OutputInterface::VERBOSITY_VERY_VERBOSE,
                0,
                ['Configuration file loaded: {configFile}'],
            ],
            'ReturnsSuccessForEmptyTestSuite' => [
                'tests/Fixtures/configuration-empty.xml',
                OutputInterface::VERBOSITY_NORMAL,
                0,
                ['No tests found to validate.'],
            ],
            'ReturnsFailForNonExistentClasses' => [
                'tests/Fixtures/configuration-nonexistent.xml',
                OutputInterface::VERBOSITY_NORMAL,
                1,
                [
                    'Invalid - ',
                    'CoversValidator {VERSION}',
                    'There were 1 test(s) with invalid @covers tags.',
                ],
            ],
            'ReturnsFailForEmptyCoversTag' => [
                'tests/Fixtures/configuration-emptycovers.xml',
                OutputInterface::VERBOSITY_NORMAL,
                1,
                [
                    'Invalid - ',
                    'There were 1 test(s) with invalid @covers tags.',
                ],
            ],
            'ReturnsFailForInvalidCoversTagWithProvider' => [
                'tests/Fixtures/configuration-nonexistentprovider.xml',
                OutputInterface::VERBOSITY_NORMAL,
                1,
                [
                    'Invalid - ',
                    'There were 1 test(s) with invalid @covers tags.',
                ],
            ],
            'ReturnsSuccessForExistingClasses' => [
                'tests/Fixtures/configuration-existing.xml',
                OutputInterface::VERBOSITY_DEBUG,
                0,
                [
                    'Valid - ',
                    'Validating ',
                ],
            ],
            'ReturnsSuccessForValidCoversTagWithProvider' => [
                'tests/Fixtures/configuration-existingprovider.xml',
                OutputInterface::VERBOSITY_NORMAL,
                0,
                [
                    'Validation complete. All @covers tags are valid.',
                ],
            ],
            'ReturnsFailForComboClasses' => [
                'tests/Fixtures/configuration-all.xml',
                OutputInterface::VERBOSITY_NORMAL,
                1,
                [
                    'Invalid - ',
                    'There were 1 test(s) with invalid @covers tags.',
                ],
            ],
            'SkipsEmptyTestClasses' => [
                'tests/Fixtures/configuration-multi-testsuite.xml',
                OutputInterface::VERBOSITY_DEBUG,
                0,
                [
                    'Validation complete. All @covers tags are valid.',
                ],
            ],
        ];
    }

    /**
     * @dataProvider provideIntegration
     */
    public function testBin($configFile, $verbosity, int $expectExitCode, array $expectOutput)
    {
        $projectDir = dirname(dirname(dirname(__FILE__)));
        $pipes = null;
        $verbosityArg = [
            OutputInterface::VERBOSITY_VERY_VERBOSE => '-vv',
            OutputInterface::VERBOSITY_DEBUG => '-vvv',
        ][$verbosity] ?? '';
        $proc = proc_open(
            "./covers-validator {$verbosityArg} -c ".escapeshellarg($configFile),
            [
                ['pipe', 'r'],
                ['pipe', 'w'],
                ['pipe', 'w'],
            ],
            $pipes,
            $projectDir
        );
        $this->assertNotNull($proc);

        fclose($pipes[0]);
        $stdout = stream_get_contents($pipes[1]);
        $stderr = stream_get_contents($pipes[2]);
        fclose($pipes[1]);
        fclose($pipes[2]);
        $exitCode = proc_close($proc);

        $this->assertEquals('', $stderr, 'stderr');
        $this->assertSame($expectExitCode, $exitCode, 'exit code');
        foreach ($expectOutput as $expectLine) {
            $expectLine = strtr($expectLine, [
                '{configFile}' => realpath($configFile),
                '{VERSION}' => CoversValidator::VERSION,
            ]);
            $this->assertStringContainsString($expectLine, $stdout, 'stdout');
        }
    }

    /**
     * @dataProvider provideIntegration
     */
    public function testExecute($configFile, $verbosity, int $expectExitCode, array $expectOutput)
    {
        $app = new CoversValidator();
        /** @var ValidateCommand $command */
        $command = $app->find('validate');
        $commandTester = new CommandTester($command);
        $exitCode = $commandTester->execute(
            [
                '-c' => $configFile,
            ],
            [
                'verbosity' => $verbosity,
            ]
        );
        $stdout = $commandTester->getDisplay();

        $this->assertSame($expectExitCode, $exitCode, 'exit code');
        foreach ($expectOutput as $expectLine) {
            $expectLine = strtr($expectLine, [
                '{configFile}' => realpath($configFile),
                '{VERSION}' => CoversValidator::VERSION,
            ]);
            $this->assertStringContainsString($expectLine, $stdout, 'stdout');
        }
    }

    public function testApplicationHasDefaultCommand()
    {
        $input = new ArrayInput([
            '-c' => 'tests/Fixtures/configuration-empty.xml',
        ]);

        $app = new CoversValidator();
        $exitCode = $app->doRun($input, new NullOutput());

        $this->assertEquals(0, $exitCode);
    }

    public function testBootstrapOptionWorks()
    {
        $input = new ArrayInput([
            '-c' => 'tests/Fixtures/configuration-empty.xml',
            '--bootstrap' => 'tests/Fixtures/bootstrap-3.php',
        ]);

        $app = new CoversValidator();
        $exitCode = $app->doRun($input, new NullOutput());

        $this->assertEquals(0, $exitCode);
    }
}
