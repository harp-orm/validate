<?php

namespace Harp\Validate\Test;

use Harp\Validate\Asserts;
use Harp\Validate\Assert;

/**
 * @group   asserts
 * @coversDefaultClass Harp\Validate\Asserts
 */
class AssertsTest extends AbstractTestCase
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
     */
    public function testConstruct()
    {
        $assertObjects = array(
            $this->getMockForAbstractClass('Harp\Validate\Assert\AbstractAssertion', ['name']),
            $this->getMockForAbstractClass('Harp\Validate\Assert\AbstractAssertion', ['name']),
        );

        $asserts = new Asserts($assertObjects);

        $this->assertCount(2, $asserts);
        $this->assertFalse($asserts->isEmpty());

        $this->assertEquals($asserts->key(), $asserts->all()->key());

        foreach ($asserts as $assert)
        {
            $this->assertContains($assert, $assertObjects);
            $this->assertTrue($asserts->contains($assert));
        }

        $asserts->rewind();

        $this->assertFalse($asserts->isEmpty());

        $all = $asserts->all();

        $this->assertCount(2, $all);

        foreach ($all as $assert)
        {
            $this->assertContains($assert, $assertObjects);
            $this->assertTrue($all->contains($assert));
        }

    }

    /**
     * @covers ::getErrors
     */
    public function testGetErrors()
    {
        $subject = (object) [
            'user_email' => 'test@example.com',
            'subscribe_url' => 'http://example.com',
            'subscribe_ip' => '23.123.214.213',
        ];

        $asserts = new Asserts(array(
            new Assert\Present('user_email'),
            new Assert\Email('user_email'),
            new Assert\URL('subscribe_url'),
            new Assert\IP('subscribe_ip'),
        ));

        $errors = $asserts->getErrors($subject);

        $this->assertTrue($errors->isEmpty());

        $subject = (object) [
            'user_email' => 'test',
            'subscribe_url' => 'http:/',
            'subscribe_ip' => '23.123',
        ];

        $errors = $asserts->getErrors($subject);

        $this->assertContainsOnlyInstancesOf('Harp\Validate\Error', $errors);

        $expected = implode(', ', array(
            'user_email should be a valid email',
            'subscribe_url should be a valid URL address',
            'subscribe_ip is invalid',
        ));

        $this->assertEquals($expected, $errors->humanize());
    }

    /**
     * @covers ::onlyFor
     */
    public function testOnlyFor()
    {
        $assert1 = new Assert\Present('user_email');
        $assert2 = new Assert\Email('user_email');
        $assert3 = new Assert\URL('subscribe_url');
        $assert4 = new Assert\IP('subscribe_ip');

        $asserts = new Asserts(array($assert1, $assert2, $assert3, $assert4));

        $filtered = $asserts->onlyFor('user_email');

        $this->assertCount(2, $filtered);
        $this->assertTrue($filtered->all()->contains($assert1));
        $this->assertTrue($filtered->all()->contains($assert2));
    }
}
