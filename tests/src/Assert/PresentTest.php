<?php

namespace Harp\Validate\Test;

use Harp\Validate\Assert\Present;
use stdClass;

/**
 * @group   assert.present
 */
class PresentTest extends AbstractTestCase
{
    public function dataIsValid()
    {
        return array(
            array('10', true),
            array('something', true),
            array(new stdClass(), true),
            array(array(), true),
            array(0, true),
            array('0', true),
            array(false, false),
            array(null, false),
            array('', false),
        );
    }

    /**
     * @dataProvider dataIsValid
     * @covers Harp\Validate\Assert\Present::isValid
     */
    public function testIsValid($value, $expected)
    {
        $this->assertSame($expected, Present::isValid($value));
    }

    public function dataExecute()
    {
        return array(
            array('something', true),
            array(null, 'test must be present'),
            array('', 'test must be present'),
            array(false, 'test must be present'),
            array(0, true),
            array('0', true),
            array(new stdClass(), true),
        );
    }

    /**
     * @dataProvider dataExecute
     * @covers Harp\Validate\Assert\Present::execute
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
