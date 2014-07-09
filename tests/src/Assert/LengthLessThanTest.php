<?php

namespace Harp\Validate\Test;

use Harp\Validate\Assert\LengthLessThan;
use stdClass;

/**
 * @group   assert.length_less_than
 * @coversDefaultClass Harp\Validate\Assert\LengthLessThan
 */
class LengthLessTest extends AbstractTestCase
{
    public function dataExecute()
    {
        return [
            ['something', 20, true],
            ['something', 10, true],
            ['something', 9, 'test should be less than 9 letters'],
            ['something', 4, 'test should be less than 4 letters'],
            ['тест', 10, true],
            ['тест', 5, true],
            ['тест', 4, 'test should be less than 4 letters'],
            ['тест', 3, 'test should be less than 3 letters'],
        ];
    }

    /**
     * @dataProvider dataExecute
     * @covers ::execute
     */
    public function testExecute($value, $length, $expected)
    {
        $assertion = new LengthLessThan('test', $length);

        $this->assertAssertion($expected, $assertion, $value);
    }

    /**
     * @covers ::__construct
     * @covers ::getLength
     */
    public function testConstruct()
    {
        $assertion = new LengthLessThan('test', 9, 'custom message');

        $this->assertEquals(9, $assertion->getLength());
        $this->assertEquals('test', $assertion->getName());
        $this->assertEquals('custom message', $assertion->getMessage());
    }
}
