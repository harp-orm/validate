<?php

namespace Harp\Validate\Assert;

use Harp\Validate\Error;

/**
 * @author    Ivan Kerin <ikerin@gmail.com>
 * @copyright (c) 2014 Clippings Ltd.
 * @license   http://spdx.org/licenses/BSD-3-Clause
 */
abstract class AbstractLengthAssertion extends AbstractValueAssertion
{
    /**
     * @param  string  $value
     * @return integer
     */
    public static function getValueLength($value)
    {
        $value = (string) $value;

        return mb_strlen($value, mb_detect_encoding($value));
    }

    /**
     * @var integer
     */
    private $length;

    /**
     * @param string  $name
     * @param integer $length
     * @param string  $message
     */
    public function __construct($name, $length, $message = ':name is invalid')
    {
        $this->length = (int) $length;

        parent::__construct($name, $message);
    }

    /**
     * @return integer
     */
    public function getLength()
    {
        return $this->length;
    }

    /**
     * @return array
     */
    public function getMessageParameters()
    {
        return parent::getMessageParameters() + [
            ':length' => $this->length,
        ];
    }
}
