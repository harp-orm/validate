<?php

namespace CL\Carpo\Assert;

use CL\Carpo\Error;
use InvalidArgumentException;

/**
 * Assert if the value is present in an array, uses a simple in_array call.
 * Will throw InvalidArgumentException if the array is empty.
 *
 * @author    Ivan Kerin <ikerin@gmail.com>
 * @copyright (c) 2014 Clippings Ltd.
 * @license   http://spdx.org/licenses/BSD-3-Clause
 */
class InArray extends AbstractAssertion
{
    /**
     * @var array
     */
    protected $array;

    /**
     * @param string $name
     * @param array  $array
     * @param string $message
     */
    public function __construct($name, array $array, $message = ':name is invalid')
    {
        if (empty($array)) {
            throw new InvalidArgumentException('Array should not be empty');
        }

        $this->array = $array;

        parent::__construct($name, $message);
    }

    /**
     * @return array
     */
    public function getArray()
    {
        return $this->array;
    }

    /**
     * @param  object|array $subject
     * @return Error|null
     */
    public function execute($subject)
    {
        if ($this->issetProperty($subject, $this->getName())) {
            $value = $this->getProperty($subject, $this->getName());

            if (! in_array($value, $this->array)) {
                return new Error($this->getMessage(), $this->getName());
            }
        }
    }
}
