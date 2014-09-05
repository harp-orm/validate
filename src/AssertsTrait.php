<?php

namespace Harp\Validate;

use Closure;

/**
 * Add this trait to your object to make them "validateable"
 *
 * @author     Ivan Kerin <ikerin@gmail.com>
 * @copyright  (c) 2014 Clippings Ltd.
 * @license    http://spdx.org/licenses/BSD-3-Clause
 */
trait AssertsTrait
{
    /**
     * @var Errors
     */
    private $asserts;

    /**
     * Get Errors, fillid in when you call "validate"
     *
     * @return Errors
     */
    public function getAsserts()
    {
        if (! $this->asserts) {
            $this->asserts = new Asserts();
        }

        return $this->asserts;
    }

    /**
     * @return boolean
     */
    public function addAssert(Assert\AbstractAssertion $assert)
    {
        $this->getAsserts()->add($assert);

        return $this;
    }

    public function assertCallback(
        $name,
        Closure $callback,
        $message = ':name is invalid'
    ) {
        return $this->addAssert(new Assert\Callback($name, $callback, $message));
    }

    public function assertEmail(
        $name,
        $message = ':name should be a valid email'
    ) {
        return $this->addAssert(new Assert\Email($name, $message));
    }

    public function assertEmailStrict(
        $name,
        $message = ':name should be a valid email'
    ) {
        return $this->addAssert(new Assert\EmailStrict($name, $message));
    }

    public function assertGreaterThan(
        $name,
        $value,
        $message = ':name should be greater than :value'
    ) {
        return $this->addAssert(new Assert\GreaterThan($name, $value, $message));
    }

    public function assertInArray(
        $name,
        array $array,
        $message = ':name is invalid'
    ) {
        return $this->addAssert(new Assert\InArray($name, $array, $message));
    }

    public function assertIP(
        $name,
        $message = ':name is invalid'
    ) {
        return $this->addAssert(new Assert\IP($name, $message));
    }

    public function assertIsInteger(
        $name,
        $message = ':name should be a valid number'
    ) {
        return $this->addAssert(new Assert\IsInteger($name, $message));
    }

    public function assertIsInstanceOf(
        $name,
        $class,
        $message = ':name is invalid'
    ) {
        return $this->addAssert(new Assert\IsInstanceOf($name, $class, $message));
    }

    public function assertIsFloat(
        $name,
        $message = ':name should be a valid number'
    ) {
        return $this->addAssert(new Assert\IsFloat($name, $message));
    }

    public function assertLengthBetween(
        $name,
        $length,
        $maxLength,
        $message = ':name should be between :length and :maxLength letters'
    ) {
        return $this->addAssert(new Assert\LengthBetween($name, $length, $maxLength, $message));
    }

    public function assertLengthEquals(
        $name,
        $length,
        $message = ':name should be :length letters'
    ) {
        return $this->addAssert(new Assert\LengthEquals($name, $length, $message));
    }

    public function assertLengthGreaterThan(
        $name,
        $length,
        $message = ':name should be more than :length letters'
    ) {
        return $this->addAssert(new Assert\LengthGreaterThan($name, $length, $message));
    }

    public function assertLengthLessThan(
        $name,
        $length,
        $message = ':name should be less than :length letters'
    ) {
        return $this->addAssert(new Assert\LengthLessThan($name, $length, $message));
    }

    public function assertLessThan(
        $name,
        $value,
        $message = ':name should be less than :value'
    ) {
        return $this->addAssert(new Assert\LessThan($name, $value, $message));
    }

    public function assertMatches(
        $name,
        $matches,
        $message = ':name must match :matches'
    ) {
        return $this->addAssert(new Assert\Matches($name, $matches, $message));
    }

    public function assertPresent(
        $name,
        $message = ':name must be present'
    ) {
        return $this->addAssert(new Assert\Present($name, $message));
    }

    public function assertRegEx(
        $name,
        $pattern,
        $message = ':name is invalid')
    {
        return $this->addAssert(new Assert\RegEx($name, $pattern, $message));
    }

    public function assertURL(
        $name,
        $message = ':name should be a valid URL address'
    ) {
        return $this->addAssert(new Assert\URL($name, $message));
    }

    public function assertURLStrict(
        $name,
        $message = ':name should be a valid URL address'
    ) {
        return $this->addAssert(new Assert\URLStrict($name, $message));
    }
}
