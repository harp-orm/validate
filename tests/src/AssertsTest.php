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
     * @covers CL\Carpo\Asserts::all
     * @covers CL\Carpo\Asserts::add
     * @covers CL\Carpo\Asserts::set
     * @covers CL\Carpo\Asserts::next
     * @covers CL\Carpo\Asserts::current
     * @covers CL\Carpo\Asserts::valid
     * @covers CL\Carpo\Asserts::count
     * @covers CL\Carpo\Asserts::key
     * @covers CL\Carpo\Asserts::rewind
     * @covers CL\Carpo\Asserts::contains
     * @covers CL\Carpo\Asserts::isEmpty
     */
    public function testConstruct()
    {
        $assertObjects = array(
            $this->getMock('CL\Carpo\Assert\AbstractAssertion', array('execute'), array('name')),
            $this->getMock('CL\Carpo\Assert\AbstractAssertion', array('execute'), array('name')),
        );

        $asserts = new Asserts($assertObjects);

        $this->assertCount(2, $asserts);
        $this->assertFalse($asserts->isEmpty());

        foreach ($asserts as $assert)
        {
            $this->assertContains($assert, $assertObjects);
            $this->assertTrue($asserts->contains($assert));
        }

        $asserts->rewind();

        $this->assertFalse($asserts->isEmpty());

        $all = $asserts->all();

        $this->assertCount(2, $all);

        foreach ($all as $i => $assert)
        {
            $this->assertSame($assertObjects[$i], $assert);
            $this->assertTrue($all->contains($assert));
        }

    }

    /**
     * @covers CL\Carpo\Asserts::validate
     * @covers CL\Carpo\Assert\AbstractAssertion::issetProperty
     * @covers CL\Carpo\Assert\AbstractAssertion::getProperty
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

        $this->assertTrue($errors->isEmpty());

        $subject->user_email = 'test';
        $subject->subscribe_url = 'http:/';
        $subject->subscribe_ip = '23.123';

        $errors = $asserts->validate($subject);

        $this->assertContainsOnlyInstancesOf('CL\Carpo\Error', $errors);

        $expected = implode(', ', array(
            'user_email should be a valid email',
            'subscribe_url should be a valid URL address',
            'subscribe_ip is invalid',
        ));

        $this->assertEquals($expected, $errors->humanize());
    }

    /**
     * @covers CL\Carpo\Asserts::validate
     * @covers CL\Carpo\Assert\AbstractAssertion::issetProperty
     * @covers CL\Carpo\Assert\AbstractAssertion::getProperty
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

        $this->assertTrue($errors->isEmpty());

        $subject['user_email'] = 'test';
        $subject['subscribe_url'] = 'http:/';
        $subject['subscribe_ip'] = '23.123';

        $errors = $asserts->validate($subject);

        $this->assertContainsOnlyInstancesOf('CL\Carpo\Error', $errors);

        $expected = implode(', ', array(
            'user_email should be a valid email',
            'subscribe_url should be a valid URL address',
            'subscribe_ip is invalid',
        ));

        $this->assertEquals($expected, $errors->humanize());
    }
}
