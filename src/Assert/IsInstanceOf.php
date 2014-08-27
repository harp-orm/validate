<?php

namespace Harp\Validate\Assert;

use InvalidArgumentException;

/**
 * Assert if the value is present in an array, uses a simple in_array call.
 * Will throw InvalidArgumentException if the array is empty.
 *
 * @author    Ivan Kerin <ikerin@gmail.com>
 * @copyright (c) 2014 Clippings Ltd.
 * @license   http://spdx.org/licenses/BSD-3-Clause
 */
class IsInstanceOf extends AbstractValueAssertion
{
    /**
     * @var string
     */
    private $class;

    /**
     * @param string $name
     * @param string $class
     * @param string $message
     */
    public function __construct($name, $class, $message = ':name is invalid')
    {
        if (! class_exists($class) and ! interface_exists($class)) {
            throw new InvalidArgumentException(
                sprintf('%s should be a valid class or interface', $class)
            );
        }

        $this->class = $class;

        parent::__construct($name, $message);
    }

    /**
     * @return class
     */
    public function getClass()
    {
        return $this->class;
    }

    /**
     * @param  mixed $value
     * @return boolean
     */
    public function isValid($value)
    {
        return is_a($value, $this->class);
    }
}
