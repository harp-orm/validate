<?php

namespace Harp\Validate\Test;

use Harp\Validate\Errors;
use Harp\Validate\Error;
use Harp\Validate\Assert;
use stdClass;

/**
 * @group   errors
 * @coversDefaultClass Harp\Validate\AssertsTrait
 */
class AssertsTraitTest extends AbstractTestCase
{
    /**
     * @covers ::getAsserts
     * @covers ::addAssert
     */
    public function testConstruct()
    {
        $config = new TestConfig();

        $asserts = $config->getAsserts();

        $this->assertInstanceOf('Harp\Validate\Asserts', $asserts);
        $this->assertCount(0, $asserts);

        $present = new Assert\Present('test');

        $config->addAssert($present);

        $this->assertCount(1, $config->getAsserts());

        $this->assertContains($present, $config->getAsserts()->all());
    }

    public function dataShortcuts()
    {
        $callback = function () {
            return true;
        };

        return [
            ['assertCallback', ['test', $callback], new Assert\Callback('test', $callback)],
            ['assertCallback', ['test', $callback, 'test message'], new Assert\Callback('test', $callback, 'test message')],

            ['assertEmail', ['test'], new Assert\Email('test')],
            ['assertEmail', ['test', 'test message'], new Assert\Email('test', 'test message')],

            ['assertEmailStrict', ['test'], new Assert\EmailStrict('test')],
            ['assertEmailStrict', ['test', 'test message'], new Assert\EmailStrict('test', 'test message')],

            ['assertGreaterThan', ['test', 2], new Assert\GreaterThan('test', 2)],
            ['assertGreaterThan', ['test', 3, 'test message'], new Assert\GreaterThan('test', 3, 'test message')],

            ['assertInArray', ['test', [2, 5]], new Assert\InArray('test', [2, 5])],
            ['assertInArray', ['test', [3, 23], 'test message'], new Assert\InArray('test', [3, 23], 'test message')],

            ['assertIP', ['test'], new Assert\IP('test')],
            ['assertIP', ['test', 'test message'], new Assert\IP('test', 'test message')],

            ['assertIsInteger', ['test'], new Assert\IsInteger('test')],
            ['assertIsInteger', ['test', 'test message'], new Assert\IsInteger('test', 'test message')],

            ['assertIsInstanceOf', ['test', 'stdClass'], new Assert\IsInstanceOf('test', 'stdClass')],
            ['assertIsInstanceOf', ['test', 'stdClass', 'test message'], new Assert\IsInstanceOf('test', 'stdClass', 'test message')],

            ['assertIsFloat', ['test'], new Assert\IsFloat('test')],
            ['assertIsFloat', ['test', 'test message'], new Assert\IsFloat('test', 'test message')],

            ['assertLengthBetween', ['test', 2, 4], new Assert\LengthBetween('test', 2, 4)],
            ['assertLengthBetween', ['test', 3, 5, 'test message'], new Assert\LengthBetween('test', 3, 5, 'test message')],

            ['assertLengthEquals', ['test', 2], new Assert\LengthEquals('test', 2)],
            ['assertLengthEquals', ['test', 3, 'test message'], new Assert\LengthEquals('test', 3, 'test message')],

            ['assertLengthGreaterThan', ['test', 2], new Assert\LengthGreaterThan('test', 2)],
            ['assertLengthGreaterThan', ['test', 3, 'test message'], new Assert\LengthGreaterThan('test', 3, 'test message')],

            ['assertLengthLessThan', ['test', 2], new Assert\LengthLessThan('test', 2)],
            ['assertLengthLessThan', ['test', 3, 'test message'], new Assert\LengthLessThan('test', 3, 'test message')],

            ['assertLessThan', ['test', 2], new Assert\LessThan('test', 2)],
            ['assertLessThan', ['test', 3, 'test message'], new Assert\LessThan('test', 3, 'test message')],

            ['assertMatches', ['test', 'test2'], new Assert\Matches('test', 'test2')],
            ['assertMatches', ['test', 'test3', 'test message'], new Assert\Matches('test', 'test3', 'test message')],

            ['assertPresent', ['test'], new Assert\Present('test')],
            ['assertPresent', ['test', 'test message'], new Assert\Present('test', 'test message')],

            ['assertRegEx', ['test', '/asd/'], new Assert\RegEx('test', '/asd/')],
            ['assertRegEx', ['test', '/asd32/', 'test message'], new Assert\RegEx('test', '/asd32/', 'test message')],

            ['assertURL', ['test'], new Assert\URL('test')],
            ['assertURL', ['test', 'test message'], new Assert\URL('test', 'test message')],

            ['assertURLStrict', ['test'], new Assert\URLStrict('test')],
            ['assertURLStrict', ['test', 'test message'], new Assert\URLStrict('test', 'test message')],
        ];
    }

    /**
     * @dataProvider dataShortcuts
     *
     * @param  string         $methodName
     * @param  array          $arguments
     * @param  AbstractAssert $expected
     */
    public function testShortcuts($methodName, array $arguments, Assert\AbstractAssertion $expected)
    {
        $config = new TestConfig();

        $config = $this->getMock('Harp\Validate\Test\TestConfig', ['addAssert']);

        $config
            ->expects($this->once())
            ->method('addAssert')
            ->with($this->equalTo($expected));

        call_user_func_array([$config, $methodName], $arguments);
    }
}
