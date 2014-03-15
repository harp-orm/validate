<?php namespace CL\Carpo\Test;

use CL\Carpo\Assert\AbstractAssertion;
use CL\Carpo\Error;
use PHPUnit_Framework_TestCase;
use stdClass;

/**
 * @package Jam
 * @author Ivan Kerin
 */
abstract class AbstractTestCase extends \PHPUnit_Framework_TestCase {

    public function assertAssertion($expected, AbstractAssertion $assertion, $value)
    {
        $object = new stdClass();
        $object->{$assertion->getName()} = $value;

        $result = $assertion->execute($object);

        if ($expected === true) {
            $message = sprintf('Assertion %s should pass', get_class($assertion));
            $this->assertTrue(is_null($result), $message);
        } else {
            $message = sprintf('Assertion %s should fail', get_class($assertion));
            $this->assertTrue($result instanceof Error, $message);
            $this->assertEquals($expected, $result->getMessage());
        }
    }
}
