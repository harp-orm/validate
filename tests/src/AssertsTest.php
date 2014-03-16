<?php

namespace CL\Carpo\Test;

use CL\Carpo\Asserts;
use CL\Carpo\Assert\AbstractAssertion;
use CL\Carpo\Assert;
use stdClass;

/**
 * @group   asserts
 */
class AssertsTest extends AbstractTestCase
{
    /**
     * @covers CL\Carpo\Asserts::__construct
     * @covers CL\Carpo\Asserts::next
     * @covers CL\Carpo\Asserts::current
     * @covers CL\Carpo\Asserts::valid
     * @covers CL\Carpo\Asserts::count
     * @covers CL\Carpo\Asserts::key
     */
    public function testConstruct()
    {
        $assertObjects = array(
            $this->getMock('CL\Carpo\Assert\AbstractAssertion', array('execute'), array('name')),
            $this->getMock('CL\Carpo\Assert\AbstractAssertion', array('execute'), array('name')),
        );

        $asserts = new Asserts($assertObjects);

        $this->assertCount(2, $asserts);

        foreach ($asserts as $i => $assert)
        {
            $this->assertSame($assertObjects[$i], $assert);
            $this->assertTrue($asserts->contains($assert));
        }
    }

    /**
     * @covers CL\Carpo\Asserts::validate
     */
    public function testValidateObject()
    {
        $subject = new stdClass();

        $subject->user_email = 'test@example.com';
        $subject->subscribe_url = 'http://example.com';
        $subject->subscribe_ip = '23.123.214.213';

        $asserts = new Asserts(array(
            new Assert\Present('user_email'),
            new Assert\Email('user_email', Assert\Email::STRICT),
            new Assert\URL('subscribe_url'),
            new Assert\IP('subscribe_ip'),
        ));

        $errors = $asserts->validate($subject);

        $this->assertEmpty($errors);

        $subject->user_email = 'test';
        $subject->subscribe_url = 'http:/';
        $subject->subscribe_ip = '23.123';

        $errors = $asserts->validate($subject);

        $errors = array_map(function($error) {
            return $error->getMessage();
        }, $errors);

        $expected = array(
            'user_email should be a valid email',
            'subscribe_url should be a valid URL address',
            'subscribe_ip should be a valid IP address',
        );

        $this->assertEquals($expected, $errors);
    }

    /**
     * @covers CL\Carpo\Asserts::validate
     */
    public function testValidateArray()
    {
        $subject = array();

        $subject['user_email'] = 'test@example.com';
        $subject['subscribe_url'] = 'http://example.com';
        $subject['subscribe_ip'] = '23.123.214.213';

        $asserts = new Asserts(array(
            new Assert\Present('user_email'),
            new Assert\Email('user_email', Assert\Email::STRICT),
            new Assert\URL('subscribe_url'),
            new Assert\IP('subscribe_ip'),
        ));

        $errors = $asserts->validate($subject);

        $this->assertEmpty($errors);

        $subject['user_email'] = 'test';
        $subject['subscribe_url'] = 'http:/';
        $subject['subscribe_ip'] = '23.123';

        $errors = $asserts->validate($subject);

        $errors = array_map(function($error) {
            return $error->getMessage();
        }, $errors);

        $expected = array(
            'user_email should be a valid email',
            'subscribe_url should be a valid URL address',
            'subscribe_ip should be a valid IP address',
        );

        $this->assertEquals($expected, $errors);
    }
}
