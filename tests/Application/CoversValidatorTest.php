<?php

namespace OckCyp\CoversValidator\Tests\Application;

use OckCyp\CoversValidator\Application\CoversValidator;
use OckCyp\CoversValidator\Tests\BaseTestCase;

class CoversValidatorTest extends BaseTestCase
{
    /**
     * @covers OckCyp\CoversValidator\Application\CoversValidator
     */
    public function testApplicationIsRight()
    {
        $app = new CoversValidator;
        $defaultCommands = $app->all();
        $definition = $app->getDefinition();

        $this->assertEmpty($definition->getArguments());
        $this->assertArrayHasKey('validate', $defaultCommands);
        $this->assertInstanceOf(
            'OckCyp\CoversValidator\Command\ValidateCommand',
            $defaultCommands['validate']
        );
    }
}
