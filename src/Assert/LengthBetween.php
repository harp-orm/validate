<?php

namespace Harp\Validate\Assert;

use InvalidArgumentException;

/**
 * Assert that the value's string length is between two set lengths (including). Uses mb_strlen() internally.
 *
 * @author    Ivan Kerin <ikerin@gmail.com>
 * @copyright (c) 2014 Clippings Ltd.
 * @license   http://spdx.org/licenses/BSD-3-Clause
 */
class LengthBetween extends AbstractLengthAssertion
{
    /**
     * @var integer
     */
    private $maxLength;

    /**
     * @param string  $name
     * @param integer $length
     * @param integer $maxLength
     * @param string  $message
     */
    public function __construct($name, $length, $maxLength, $message = ':name should be between :length and :maxLength letters')
    {
        if ($length >= $maxLength) {
            throw new InvalidArgumentException('Min should be less than max');
        }

        $this->maxLength = (int) $maxLength;

        parent::__construct($name, $length, $message);
    }

    /**
     * @return array
     */
    public function getMessageParameters()
    {
        return parent::getMessageParameters() + [
            ':maxLength' => $this->maxLength,
        ];
    }

    /**
     * @return integer
     */
    public function getMaxLength()
    {
        return $this->maxLength;
    }

    /**
     * @param  mixed $value
     * @return boolean
     */
    public function isValid($value)
    {
        $length = self::getValueLength($value);

        return ($length >= $this->getLength() and $length <= $this->maxLength);
    }
}
