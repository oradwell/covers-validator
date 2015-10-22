<?php

namespace OckCyp\CoversValidator\Tests;

use OckCyp\CoversValidator\Validator;

class ValidatorTest extends BaseTestCase
{
    /**
     * @covers OckCyp\CoversValidator\Validator::isValid
     */
    public function testReturnsFalseForNonExistentClassBeingCovered()
    {
        $validator = new Validator;
        $this->assertFalse(
            $validator->isValid(
                $this->getFixtureClassName('TestCoveringNonExistentClassTest'),
                'testDummyTest'
            )
        );
    }

    /**
     * @covers OckCyp\CoversValidator\Validator::isValid
     */
    public function testReturnsTrueForExistingClassBeingCovered()
    {
        $validator = new Validator;
        $this->assertTrue(
            $validator->isValid(
                $this->getFixtureClassName('TestCoveringExistingClassTest'),
                'testDummyTest'
            )
        );
    }
}
