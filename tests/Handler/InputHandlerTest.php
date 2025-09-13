<?php

namespace OckCyp\CoversValidator\Tests\Handler;

use OckCyp\CoversValidator\Handler\InputHandler;
use OckCyp\CoversValidator\Model\ConfigurationHolder;
use OckCyp\CoversValidator\Tests\BaseTestCase;
use Prophecy\Prophet;

/**
 * @coversDefaultClass \OckCyp\CoversValidator\Handler\InputHandler
 */
class InputHandlerTest extends BaseTestCase
{
    /**
     * @var Prophet|null
     */
    private $prophet;

    /**
     * @before
     */
    protected function setUpProphet()
    {
        $this->prophet = new Prophet();
    }

    /**
     * @after
     */
    protected function tearDownProphet()
    {
        $this->prophet->checkPredictions();
    }

    /**
     * @covers ::handleInput
     */
    public function testHandlesInputWithNoBootstrap()
    {
        $input = $this->prophet->prophesize(
            'Symfony\Component\Console\Input\InputInterface'
        );
        $input->getOption('configuration')
            ->shouldBeCalled()
            ->willReturn('tests/Fixtures/configuration-empty.xml');
        $input->getOption('bootstrap')
            ->shouldBeCalled()
            ->willReturn(null);

        $config = InputHandler::handleInput($input->reveal());

        $this->assertInstanceOf(ConfigurationHolder::class, $config);
    }

    /**
     * @covers ::handleInput
     */
    public function testHandlesInputWithBootstrapInConfig()
    {
        $input = $this->prophet->prophesize(
            'Symfony\Component\Console\Input\InputInterface'
        );
        $input->getOption('configuration')
            ->shouldBeCalled()
            ->willReturn('tests/Fixtures/configuration-bootstrap.xml');
        $input->getOption('bootstrap')
            ->shouldBeCalled()
            ->willReturn(null);

        $this->assertFalse(
            class_exists(
                'SomeNamespace\NotAutoloaded\ClassThatNeedsBootstrap'
            )
        );

        $config = InputHandler::handleInput($input->reveal());

        $this->assertInstanceOf(ConfigurationHolder::class, $config);

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
        $input = $this->prophet->prophesize(
            'Symfony\Component\Console\Input\InputInterface'
        );
        $input->getOption('configuration')
            ->shouldBeCalled()
            ->willReturn('tests/Fixtures/configuration-bootstrap.xml');
        $input->getOption('bootstrap')
            ->shouldBeCalled()
            ->willReturn('tests/Fixtures/bootstrap-2.php');

        $this->assertFalse(
            class_exists(
                'SomeNamespace\NotAutoloaded\AnotherClassThatNeedsBootstrap'
            )
        );

        $config = InputHandler::handleInput($input->reveal());

        $this->assertInstanceOf(ConfigurationHolder::class, $config);

        $this->assertTrue(
            class_exists(
                'SomeNamespace\NotAutoloaded\AnotherClassThatNeedsBootstrap'
            )
        );
    }
}
