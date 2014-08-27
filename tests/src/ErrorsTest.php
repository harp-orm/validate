<?php

namespace Harp\Validate\Test;

use Harp\Validate\Errors;
use Harp\Validate\Error;
use Harp\Validate\Assert\Present;
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
     * @covers ::next
     * @covers ::current
     * @covers ::valid
     * @covers ::count
     * @covers ::key
     * @covers ::rewind
     * @covers ::contains
     * @covers ::isEmpty
     * @covers ::getFirst
     * @covers ::getNext
     */
    public function testConstruct()
    {
        $errorObjects = array(
            new Error(new Present('test')),
            new Error(new Present('test')),
        );

        $errors = new Errors($errorObjects);

        $this->assertCount(2, $errors);

        $this->assertEquals($errors->key(), $errors->all()->key());

        foreach ($errors as $error)
        {
            $this->assertContains($error, $errorObjects);
            $this->assertTrue($errors->contains($error));
        }

        $errors->rewind();

        $this->assertFalse($errors->isEmpty());

        $all = $errors->all();

        $this->assertCount(2, $all);

        foreach ($all as $i => $error)
        {
            $this->assertContains($error, $errorObjects);
            $this->assertTrue($all->contains($error));
        }

        $this->assertSame($errors->getFirst(), $errorObjects[0]);
        $this->assertSame($errors->getNext(), $errorObjects[1]);
        $this->assertNull($errors->getNext());
    }

    /**
     * @covers ::set
     */
    public function testSet()
    {
        $errorObjects = array(
            new Error(new Present('test')),
            new Error(new Present('test')),
        );

        $newObjects = array(
            new Error(new Present('test2')),
            new Error(new Present('test2')),
        );

        $errors = new Errors($errorObjects);

        $errors->set(new Errors($newObjects));

        $this->assertSame($errors->getFirst(), $newObjects[0]);
        $this->assertSame($errors->getNext(), $newObjects[1]);
        $this->assertNull($errors->getNext());
    }

    /**
     * @covers ::humanize
     */
    public function testHumanize()
    {
        $errorObjects = [
            new Error(new Present('name 1', 'test 1 :name')),
            new Error(new Present('name 2', 'test 2 :name')),
        ];

        $errors = new Errors($errorObjects);

        $this->assertEquals('test 1 name 1, test 2 name 2', $errors->humanize());
    }

    /**
     * @covers ::onlyFor
     */
    public function testOnlyFor()
    {
        $errorObjects = [
            new Error(new Present('name1', 'test 1 :name')),
            new Error(new Present('name1', 'test 2 :name')),
            new Error(new Present('name2', 'test 3 :name')),
        ];

        $errors = new Errors($errorObjects);

        $filtered = $errors->onlyFor('name1');

        $this->assertEquals('test 1 name1, test 2 name1', $filtered->humanize());
    }

    /**
     * @covers ::__toString
     */
    public function testToString()
    {
        $errors = $this->getMock('Harp\Validate\Errors', ['humanize']);

        $errors
            ->expects($this->once())
            ->method('humanize')
            ->will($this->returnValue('humanized'));

        $this->assertEquals('humanized', $errors->__toString());
    }
}
