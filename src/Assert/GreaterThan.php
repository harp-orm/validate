<?php

namespace Harp\Validate\Assert;

/**
 * Assert that a numeric value is bigger than a set value.
 *
 * @author    Ivan Kerin <ikerin@gmail.com>
 * @copyright (c) 2014 Clippings Ltd.
 * @license   http://spdx.org/licenses/BSD-3-Clause
 */
class GreaterThan extends AbstractValueAssertion
{
    /**
     * @var integer|float
     */
    private $value;

    /**
     * @param string        $name
     * @param integer|float $value
     * @param string        $message
     */
    public function __construct($name, $value, $message = ':name should be greater than :value')
    {
        $this->value = $value;

        parent::__construct($name, $message);
    }

    /**
     * @return array
     */
    public function getMessageParameters()
    {
        return parent::getMessageParameters() + [
            ':value' => $this->value,
        ];
    }

    /**
     * @return integer|float
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param  mixed $value
     * @return boolean
     */
    public function isValid($value)
    {
        return $value > $this->value;
    }
}
