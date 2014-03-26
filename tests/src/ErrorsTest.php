<?php

namespace CL\Carpo\Test;

use CL\Carpo\Errors;
use CL\Carpo\Error;
use stdClass;

/**
 * @group   errors
 */
class ErrorsTest extends AbstractTestCase
{
    /**
     * @covers CL\Carpo\Errors::__construct
     * @covers CL\Carpo\Errors::all
     * @covers CL\Carpo\Errors::add
     * @covers CL\Carpo\Errors::set
     * @covers CL\Carpo\Errors::next
     * @covers CL\Carpo\Errors::current
     * @covers CL\Carpo\Errors::valid
     * @covers CL\Carpo\Errors::count
     * @covers CL\Carpo\Errors::key
     * @covers CL\Carpo\Errors::rewind
     * @covers CL\Carpo\Errors::contains
     * @covers CL\Carpo\Errors::isEmpty
     * @covers CL\Carpo\Errors::getSubject
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

        $this->assertEquals($errors->key(), key($errors->all()));

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
     * @covers CL\Carpo\Errors::humanize
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
     * @covers CL\Carpo\Errors::onlyFor
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
     * @covers CL\Carpo\Errors::__toString
     */
    public function testToString()
    {
        $subject = new stdClass();

        $errors = $this->getMock('CL\Carpo\Errors', array('humanize'), array($subject));

        $errors
            ->expects($this->once())
            ->method('humanize')
            ->will($this->returnValue('humanized'));

        $this->assertEquals('humanized', $errors->__toString());
    }
}
