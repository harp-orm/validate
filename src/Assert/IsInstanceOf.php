<?php

namespace Harp\Validate\Assert;

use Harp\Validate\Error;
use InvalidArgumentException;

/**
 * Assert if the value is present in an array, uses a simple in_array call.
 * Will throw InvalidArgumentException if the array is empty.
 *
 * @author    Ivan Kerin <ikerin@gmail.com>
 * @copyright (c) 2014 Clippings Ltd.
 * @license   http://spdx.org/licenses/BSD-3-Clause
 */
class IsInstanceOf extends AbstractAssertion
{
    /**
     * @var class
     */
    protected $class;

    /**
     * @param string $name
     * @param string $class
     * @param string $message
     */
    public function __construct($name, $class, $message = ':name is invalid')
    {
        if (! class_exists($class)) {
            throw new InvalidArgumentException(
                sprintf('%s should be a valid class', $class)
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
     * @param  object|array $subject
     * @return Error|null
     */
    public function execute($subject)
    {
        if ($this->issetProperty($subject, $this->getName())) {
            $value = $this->getProperty($subject, $this->getName());

            if (! is_a($value, $this->class)) {
                return new Error($this->getMessage(), $this->getName());
            }
        }
    }
}
