<?php

namespace Harp\Validate\Test\Assert;

use Harp\Validate\Test\TestAssertion;
use Harp\Validate\Error;
use Harp\Validate\Test\AbstractTestCase;

/**
 * @group   assert.abstract_assertion
 * @coversDefaultClass Harp\Validate\Assert\AbstractAssertion
 */
class AbstractAssertionTest extends AbstractTestCase
{
    /**
     * @covers ::__construct
     * @covers ::getName
     * @covers ::getMessage
     * @covers ::getMessageParameters
     */
    public function testConstruct()
    {
        $assertion = new TestAssertion('test', 'custom message');

        $this->assertEquals('test', $assertion->getName());
        $this->assertEquals('custom message', $assertion->getMessage());
        $this->assertEquals([':name' => 'test'], $assertion->getMessageParameters());
    }
}
