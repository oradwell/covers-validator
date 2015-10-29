<?php

namespace OckCyp\CoversValidator\Tests\Handler;

use OckCyp\CoversValidator\Handler\InputHandler;
use OckCyp\CoversValidator\Tests\BaseTestCase;
use Symfony\Component\Console\Input\InputInterface;

/**
 * @coversDefaultClass OckCyp\CoversValidator\Handler\InputHandler
 */
class InputHandlerTest extends BaseTestCase
{
    /**
     * @covers ::handleInput
     */
    public function testHandlesInputWithNoBootstrap()
    {
        $input = $this->prophesize(
            'Symfony\Component\Console\Input\InputInterface'
        );
        $input->getOption('configuration')
            ->shouldBeCalled()
            ->willReturn('tests/Fixtures/configuration-empty.xml');
        $input->hasOption('bootstrap')
            ->shouldBeCalled()
            ->willReturn(false);

        $config = InputHandler::handleInput($input->reveal());

        $this->assertInstanceOf('PHPUnit_Util_Configuration', $config);
    }

    /**
     * @covers ::handleInput
     */
    public function testHandlesInputWithBootstrapInConfig()
    {
        $input = $this->prophesize(
            'Symfony\Component\Console\Input\InputInterface'
        );
        $input->getOption('configuration')
            ->shouldBeCalled()
            ->willReturn('tests/Fixtures/configuration-bootstrap.xml');
        $input->hasOption('bootstrap')
            ->shouldBeCalled()
            ->willReturn(false);

        $this->assertFalse(
            class_exists(
                'SomeNamespace\NotAutoloaded\ClassThatNeedsBootstrap'
            )
        );

        $config = InputHandler::handleInput($input->reveal());

        $this->assertInstanceOf('PHPUnit_Util_Configuration', $config);

        $this->assertTrue(
            class_exists(
                'SomeNamespace\NotAutoloaded\ClassThatNeedsBootstrap'
            )
        );
    }

    /**
     * @covers ::handleInput
     */
    public function testBootstrapInInputOverridesConfig()
    {
        $input = $this->prophesize(
            'Symfony\Component\Console\Input\InputInterface'
        );
        $input->getOption('configuration')
            ->shouldBeCalled()
            ->willReturn('tests/Fixtures/configuration-bootstrap.xml');
        $input->hasOption('bootstrap')
            ->shouldBeCalled()
            ->willReturn(true);
        $input->getOption('bootstrap')
            ->shouldBeCalled()
            ->willReturn('tests/Fixtures/bootstrap-2.php');

        $this->assertFalse(
            class_exists(
                'SomeNamespace\NotAutoloaded\AnotherClassThatNeedsBootstrap'
            )
        );

        $config = InputHandler::handleInput($input->reveal());

        $this->assertInstanceOf('PHPUnit_Util_Configuration', $config);

        $this->assertTrue(
            class_exists(
                'SomeNamespace\NotAutoloaded\AnotherClassThatNeedsBootstrap'
            )
        );
    }
}
