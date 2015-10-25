<?php

namespace OckCyp\CoversValidator\Tests;

use OckCyp\CoversValidator\Validator;
use OckCyp\CoversValidator\TestSuiteLoader;
use OckCyp\CoversValidator\ConfigLoader;
use OckCyp\CoversValidator\ConfigDeterminer;

class ValidatorTest extends BaseTestCase
{
    /**
     * @covers OckCyp\CoversValidator\Validator::isValidMethod
     */
    public function testReturnsFalseForNonExistentClassBeingCovered()
    {
        $this->assertFalse(
            Validator::isValidMethod(
                $this->getFixtureClassName('TestCoveringNonExistentClassTest'),
                'testDummyTest'
            )
        );
    }

    /**
     * @covers OckCyp\CoversValidator\Validator::isValidMethod
     */
    public function testReturnsTrueForExistingClassBeingCovered()
    {
        $this->assertTrue(
            Validator::isValidMethod(
                $this->getFixtureClassName('TestCoveringExistingClassTest'),
                'testDummyTest'
            )
        );
    }
}
