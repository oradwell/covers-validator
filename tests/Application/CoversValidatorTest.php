<?php

namespace OckCyp\CoversValidator\Tests\Application;

use OckCyp\CoversValidator\Application\CoversValidator;
use OckCyp\CoversValidator\Tests\BaseTestCase;

/**
 * @coversNothing
 */
class CoversValidatorTest extends BaseTestCase
{
    public function testApplicationIsRight()
    {
        $app = new CoversValidator();
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
