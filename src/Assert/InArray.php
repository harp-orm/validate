<?php

namespace CL\Carpo\Assert;

use CL\Carpo\Error;
use InvalidArgumentException;

/**
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
     * @var string
     */
    protected $message;

    /**
     * @param string $name
     * @param array  $array
     * @param string $message
     */
    public function __construct($name, array $array, $message = null)
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
    public function execute($object)
    {
        if ($this->issetProperty($object)) {
            $value = $this->getProperty($object);

            if (! in_array($value, $this->array)) {
                return new Error($this->getMessage(), $this->getName());
            }
        }
    }
}
