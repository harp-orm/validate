<?php

namespace Harp\Validate\Test\Assert;

use Harp\Validate\Test\TestValueAssertion;
use Harp\Validate\Error;
use Harp\Validate\Test\AbstractTestCase;

/**
 * @group   assert.abstract_assertion
 * @coversDefaultClass Harp\Validate\Assert\AbstractValueAssertion
 */
class AbstractValueAssertionTest extends AbstractTestCase
{
    /**
     * @covers ::getError
     */
    public function testGetErrorNull()
    {
        $assertion = new TestValueAssertion('test');

        $subject = (object) ['test' => 'test'];

        $result = $assertion->getError($subject);

        $this->assertNull($result);
    }

    /**
     * @covers ::getError
     */
    public function testGetErrorObject()
    {
        $assertion = new TestValueAssertion('test');

        $subject = (object) ['test' => '!!!'];

        $result = $assertion->getError($subject);

        $this->assertEquals(new Error($assertion), $result);
    }
}
