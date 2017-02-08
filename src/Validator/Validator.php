<?php

namespace OckCyp\CoversValidator\Validator;

use PHPUnit\Framework\CodeCoverageException;
use PHPUnit\Util\Test;

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
    public static function isValidMethod($class, $method)
    {
        try {
            Test::getLinesToBeCovered($class, $method);
        } catch (CodeCoverageException $e) {
            return false;
        }

        return true;
    }
}
