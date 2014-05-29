<?php

namespace Harp\Validate\Test;

use Harp\Validate\Error;
use stdClass;

/**
 * @group   error
 * @coversDefaultClass Harp\Validate\Error
 */
class ErrorTest extends AbstractTestCase
{
    /**
     * @covers ::__construct
     * @covers ::getName
     * @covers ::getParameters
     * @covers ::getMessage
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
     * @covers ::setName
     */
    public function testSetName()
    {
        $error = new Error(':name is error message', 'test');

        $this->assertEquals('test', $error->getName());

        $error->setName('Translated Name');

        $this->assertEquals('Translated Name', $error->getName());
    }

    /**
     * @covers ::getMessageParameters
     */
    public function testGetMessageParameters()
    {
        $error = new Error(':name is error message :min < :max', 'test', array(':min' => 10, ':max' => 20));

        $this->assertEquals(array(':name' => 'test', ':min' => 10, ':max' => 20), $error->getMessageParameters());
    }

    /**
     * @covers ::getFullMessage
     */
    public function testGetFullMessage()
    {
        $error = new Error(':name is error message :min < :max', 'test', array(':min' => 10, ':max' => 20));

        $this->assertEquals('test is error message 10 < 20', $error->getFullMessage());
    }

    /**
     * @covers ::setTranslator
     * @covers ::getTranslator
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
     * @covers ::__toString
     */
    public function testToString()
    {
        $error = new Error(':name is error message :min < :max', 'test', array(':min' => 10, ':max' => 20));

        $this->assertEquals('test is error message 10 < 20', (string) $error);
    }
}
