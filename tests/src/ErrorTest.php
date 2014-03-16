<?php

namespace CL\Carpo\Test;

use CL\Carpo\Error;
use stdClass;

/**
 * @group   error
 */
class ErrorTest extends AbstractTestCase
{
    /**
     * @covers CL\Carpo\Error::__construct
     * @covers CL\Carpo\Error::getName
     * @covers CL\Carpo\Error::getParameters
     * @covers CL\Carpo\Error::getMessage
     */
    public function testConstruct()
    {
        $error = new Error('%s is error message', 'test');

        $this->assertEquals('%s is error message', $error->getMessage());
        $this->assertEquals('test', $error->getName());
        $this->assertEmpty($error->getParameters());

        $error = new Error('%s is error message 2', 'test_2', 10, 20);

        $this->assertEquals('%s is error message 2', $error->getMessage());
        $this->assertEquals('test_2', $error->getName());
        $this->assertEquals(array(10, 20), $error->getParameters());
    }

    /**
     * @covers CL\Carpo\Error::setName
     */
    public function testSetName()
    {
        $error = new Error('%s is error message', 'test');

        $this->assertEquals('test', $error->getName());

        $error->setName('Translated Name');

        $this->assertEquals('Translated Name', $error->getName());
    }

    /**
     * @covers CL\Carpo\Error::getMessageParameters
     */
    public function testGetMessageParameters()
    {
        $error = new Error('%s is error message', 'test', 10, 20);

        $this->assertEquals(array('test', 10, 20), $error->getMessageParameters());
    }

    /**
     * @covers CL\Carpo\Error::getFullMessage
     */
    public function testGetFullMessage()
    {
        $error = new Error('%s is error message %s < %s', 'test', 10, 20);

        $this->assertEquals('test is error message 10 < 20', $error->getFullMessage());
    }

    /**
     * @covers CL\Carpo\Error::__toString
     */
    public function testToString()
    {
        $error = new Error('%s is error message %s < %s', 'test', 10, 20);

        $this->assertEquals('test is error message 10 < 20', (string) $error);
    }


}
