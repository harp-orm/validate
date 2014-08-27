<?php namespace Harp\Validate\Test;

use Harp\Validate\Assert\AbstractAssertion;
use Harp\Validate\Error;
use stdClass;
use PHPUnit_Framework_TestCase;

/**
 * @package Jam
 * @author Ivan Kerin
 */
abstract class AbstractTestCase extends \PHPUnit_Framework_TestCase {

    public function assertAssertion($expected, AbstractAssertion $assertion, $subject)
    {
        if (! ($subject instanceof stdClass)) {
            $subject = (object) [$assertion->getName() => $subject];
        }

        $result = $assertion->getError($subject);

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
