<?php

namespace Harp\Validate\Test;

use Harp\Validate\Assert\IsInstanceOf;
use stdClass;
use SplObjectStorage;
/**
 * @group   assert.is_instance_of
 * @coversDefaultClass Harp\Validate\Assert\IsInstanceOf
 */
class IsInstanceOfTest extends AbstractTestCase
{
    public function dataExecute()
    {
        return array(
            array(new SplObjectStorage(), 'SplObjectStorage', true),
            array(new stdClass(), 'stdClass', true),
            array(new SplObjectStorage(), 'stdClass', 'test is invalid'),
        );
    }

    /**
     * @dataProvider dataExecute
     * @covers ::execute
     */
    public function testExecute($value, $class, $expected)
    {
        $assertion = new IsInstanceOf('test', $class);

        $this->assertAssertion($expected, $assertion, $value);
    }

    /**
     * @covers ::__construct
     * @covers ::getClass
     */
    public function testConstruct()
    {
        $assertion = new IsInstanceOf('test', 'SplObjectStorage', 'custom message');

        $this->assertEquals('SplObjectStorage', $assertion->getClass());
        $this->assertEquals('test', $assertion->getName());
        $this->assertEquals('custom message', $assertion->getMessage());

        $this->setExpectedException('InvalidArgumentException', 'adsasd should be a valid class');

        new IsInstanceOf('test', 'adsasd');
    }
}
