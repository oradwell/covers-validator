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
            if (class_exists('PHPUnit\Metadata\Api\CodeCoverage', true)) {
                // PHPUnit 10+
                (new \PHPUnit\Metadata\Api\CodeCoverage())
                    ->linesToBeCovered($class, $method);
            } else {
                // PHPUnit < 10
                Test::getLinesToBeCovered($class, $method);
            }
        } catch (CodeCoverageException $e) {
            return false;
        }

        return true;
    }
}
