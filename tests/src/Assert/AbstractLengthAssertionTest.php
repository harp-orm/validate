<?php

namespace Harp\Validate\Test\Assert;

use Harp\Validate\Test\TestLengthAssertion;
use Harp\Validate\Test\AbstractTestCase;
use Harp\Validate\Assert\AbstractLengthAssertion;

/**
 * @group   assert.abstract_assertion
 * @coversDefaultClass Harp\Validate\Assert\AbstractLengthAssertion
 */
class AbstractLengthAssertionTest extends AbstractTestCase
{
    /**
     * @covers ::__construct
     * @covers ::getLength
     * @covers ::getMessageParameters
     */
    public function testConstruct()
    {
        $assertion = new TestLengthAssertion('test', 8, 'custom message');

        $this->assertEquals('test', $assertion->getName());
        $this->assertEquals('custom message', $assertion->getMessage());
        $this->assertEquals(8, $assertion->getLength());
        $this->assertEquals([':name' => 'test', ':length' => 8], $assertion->getMessageParameters());
    }

    /**
     * @covers ::getValueLength
     */
    public function testGetValueLength()
    {
        $this->assertEquals(9, AbstractLengthAssertion::getValueLength('sldkjfhal'));
        $this->assertEquals(2, AbstractLengthAssertion::getValueLength('32'));
    }
}
