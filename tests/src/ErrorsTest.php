<?php

namespace Harp\Validate\Test;

use Harp\Validate\Errors;
use Harp\Validate\Error;
use stdClass;

/**
 * @group   errors
 * @coversDefaultClass Harp\Validate\Errors
 */
class ErrorsTest extends AbstractTestCase
{
    /**
     * @covers ::__construct
     * @covers ::all
     * @covers ::add
     * @covers ::set
     * @covers ::next
     * @covers ::current
     * @covers ::valid
     * @covers ::count
     * @covers ::key
     * @covers ::rewind
     * @covers ::contains
     * @covers ::isEmpty
     * @covers ::getSubject
     */
    public function testConstruct()
    {
        $subject = new stdClass();

        $errorObjects = array(
            new Error('test', 'test'),
            new Error('test', 'test'),
        );

        $errors = new Errors($subject, $errorObjects);

        $this->assertSame($subject, $errors->getSubject());
        $this->assertCount(2, $errors);

        $this->assertEquals($errors->key(), $errors->all()->key());

        foreach ($errors as $error)
        {
            $this->assertContains($error, $errorObjects);
            $this->assertTrue($errors->contains($error));
        }

        $errors->rewind();

        $this->assertFalse($errors->isEmpty());
        $this->assertSame($subject, $errors->getSubject());

        $all = $errors->all();

        $this->assertCount(2, $all);

        foreach ($all as $i => $error)
        {
            $this->assertContains($error, $errorObjects);
            $this->assertTrue($all->contains($error));
        }
    }

    /**
     * @covers ::humanize
     */
    public function testHumanize()
    {
        $subject = new stdClass();

        $errorObjects = array(
            new Error('test 1 :name', 'name 1'),
            new Error('test 2 :name', 'name 2'),
        );

        $errors = new Errors($subject, $errorObjects);

        $this->assertEquals('test 1 name 1, test 2 name 2', $errors->humanize());
    }

    /**
     * @covers ::onlyFor
     */
    public function testOnlyFor()
    {
        $subject = new stdClass();

        $errorObjects = array(
            new Error('test 1 :name', 'name1'),
            new Error('test 2 :name', 'name1'),
            new Error('test 3 :name', 'name2'),
        );

        $errors = new Errors($subject, $errorObjects);

        $filtered = $errors->onlyFor('name1');

        $this->assertEquals('test 1 name1, test 2 name1', $filtered->humanize());
        $this->assertSame($subject, $filtered->getSubject());
    }

    /**
     * @covers ::__toString
     */
    public function testToString()
    {
        $subject = new stdClass();

        $errors = $this->getMock('Harp\Validate\Errors', array('humanize'), array($subject));

        $errors
            ->expects($this->once())
            ->method('humanize')
            ->will($this->returnValue('humanized'));

        $this->assertEquals('humanized', $errors->__toString());
    }
}
