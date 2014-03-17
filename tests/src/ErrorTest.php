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
        $error = new Error(':name is error message', 'test');

        $this->assertEquals(':name is error message', $error->getMessage());
        $this->assertEquals('test', $error->getName());
        $this->assertEmpty($error->getParameters());

        $error = new Error(':name is error message 2', 'test_2', array(':min' => 10, ':max' => 20));

        $this->assertEquals(':name is error message 2', $error->getMessage());
        $this->assertEquals('test_2', $error->getName());
        $this->assertEquals(array(':min' => 10, ':max' => 20), $error->getParameters());
    }

    /**
     * @covers CL\Carpo\Error::setName
     */
    public function testSetName()
    {
        $error = new Error(':name is error message', 'test');

        $this->assertEquals('test', $error->getName());

        $error->setName('Translated Name');

        $this->assertEquals('Translated Name', $error->getName());
    }

    /**
     * @covers CL\Carpo\Error::getMessageParameters
     */
    public function testGetMessageParameters()
    {
        $error = new Error(':name is error message :min < :max', 'test', array(':min' => 10, ':max' => 20));

        $this->assertEquals(array(':name' => 'test', ':min' => 10, ':max' => 20), $error->getMessageParameters());
    }

    /**
     * @covers CL\Carpo\Error::getFullMessage
     */
    public function testGetFullMessage()
    {
        $error = new Error(':name is error message :min < :max', 'test', array(':min' => 10, ':max' => 20));

        $this->assertEquals('test is error message 10 < 20', $error->getFullMessage());
    }

    /**
     * @covers CL\Carpo\Error::setTranslator
     * @covers CL\Carpo\Error::getTranslator
     */
    public function testTranslator()
    {
        $error = new Error(':name is error message :min < :max', 'test', array(':min' => 10, ':max' => 20));

        $currentTranslator = Error::getTranslator();

        $translator = $this->getMock('stdClass', array('test_method'));

        $translator
            ->expects($this->once())
            ->method('test_method')
            ->with($this->equalTo(':name is error message :min < :max'))
            ->will($this->returnValue('translated'));

        Error::setTranslator(array($translator, 'test_method'));

        $this->assertEquals('translated', $error->getFullMessage());

        Error::setTranslator($currentTranslator);

        $this->setExpectedException('InvalidArgumentException', 'Translator must be callable function');

        Error::setTranslator('invalid callable');
    }

    /**
     * @covers CL\Carpo\Error::__toString
     */
    public function testToString()
    {
        $error = new Error(':name is error message :min < :max', 'test', array(':min' => 10, ':max' => 20));

        $this->assertEquals('test is error message 10 < 20', (string) $error);
    }
}
