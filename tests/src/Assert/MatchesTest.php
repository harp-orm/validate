<?php

namespace Harp\Validate\Test;

use Harp\Validate\Assert\Matches;
use stdClass;

/**
 * @group   assert.matches
 */
class MatchesTest extends AbstractTestCase
{
    public function dataExecute()
    {
        return array(
            array(array('temp' => 'test', 'temp2' => 'test'), 'temp', 'temp2', true),
            array(array('temp' => 'test', 'temp2' => 's'), 'temp', 'temp2', 'temp must match temp2'),
            array(array('temp' => 'test', 'temp2' => ''), 'temp', 'temp2', 'temp must match temp2'),
            array(array(), 'temp', 'temp2', true),
        );
    }

    /**
     * @dataProvider dataExecute
     * @covers Harp\Validate\Assert\Matches::execute
     */
    public function testExecute($subject, $name, $matches, $expected)
    {
        $assertion = new Matches($name, $matches);

        $this->assertAssertion($expected, $assertion, $subject);
    }

    /**
     * @covers Harp\Validate\Assert\Matches::__construct
     * @covers Harp\Validate\Assert\Matches::getMatches
     */
    public function testConstruct()
    {
        $assertion = new Matches('test', 'test2', 'custom message');

        $this->assertEquals('test', $assertion->getName());
        $this->assertEquals('test2', $assertion->getMatches());
        $this->assertEquals('custom message', $assertion->getMessage());
    }
}
