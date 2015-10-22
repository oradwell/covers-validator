<?php

namespace OckCyp\CoversValidator;

use PHPUnit_Framework_CodeCoverageException as CodeCoverageException;
use PHPUnit_Util_Test;

class Validator
{
    /**
     * Check if the method has valid @covers and @uses tags
     *
     * @param string $class
     * @param string $method
     *
     * @return bool
     */
    public function isValid($class, $method)
    {
        try {
            PHPUnit_Util_Test::getLinesToBeCovered($class, $method);
        } catch (CodeCoverageException $e) {
            return false;
        }

        return true;
    }
}
