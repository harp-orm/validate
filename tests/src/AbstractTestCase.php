<?php namespace Harp\Validate\Test;

use Harp\Validate\Assert\AbstractAssertion;
use Harp\Validate\Error;
use PHPUnit_Framework_TestCase;
use stdClass;

/**
 * @package Jam
 * @author Ivan Kerin
 */
abstract class AbstractTestCase extends \PHPUnit_Framework_TestCase {

    public function assertAssertion($expected, AbstractAssertion $assertion, $value)
    {
        if (is_array($value)) {
            $object = $value;
        } else {
            $object = new stdClass();
            $object->{$assertion->getName()} = $value;
        }

        $result = $assertion->execute($object);

        if ($expected === true) {
            $message = sprintf('Assertion %s should pass', get_class($assertion));
            $this->assertTrue(is_null($result), $message);
        } else {
            $message = sprintf('Assertion %s should fail', get_class($assertion));
            $this->assertTrue($result instanceof Error, $message);
            $this->assertEquals($expected, $result->getFullMessage());
        }
    }
}
