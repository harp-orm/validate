<?php

namespace CL\Carpo\Test;

use CL\Carpo\Assert\Present;
use stdClass;

/**
 * @group   assert.present
 */
class PresentTest extends AbstractTestCase
{
    public function dataExecute()
    {
        return array(
            array('something', true),
            array(null, 'test must be present'),
        );
    }

    /**
     * @dataProvider dataExecute
     * @covers CL\Carpo\Assert\Present::execute
     */
    public function testExecute($value, $expected)
    {
        $assertion = new Present('test');

        $this->assertAssertion($expected, $assertion, $value);
    }

    public function testConstruct()
    {
        $assertion = new Present('test', 'custom message');
        $this->assertEquals('test', $assertion->getName());
        $this->assertEquals('custom message', $assertion->getMessage());
    }
}
