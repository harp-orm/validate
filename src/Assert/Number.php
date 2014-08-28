<?php

namespace Harp\Validate\Assert;

/**
 * Assert that the value is a number. By default only integers are allowed (Number::INTEGER).
 * If you want to check for floats you can use Number::FLOAT.
 *
 * @author    Ivan Kerin <ikerin@gmail.com>
 * @copyright (c) 2014 Clippings Ltd.
 * @license   http://spdx.org/licenses/BSD-3-Clause
 */
class Number extends AbstractValueAssertion
{
    const INTEGER = 1;
    const FLOAT = 2;

    /**
     * @param  mixed   $value
     * @return boolean
     */
    public static function isValidInteger($value)
    {
        return (is_integer($value) or ctype_digit($value));
    }

    /**
     * @param  mixed   $value
     * @return boolean
     */
    public static function isValidFloat($value)
    {
        return is_numeric($value);
    }

    /**
     * @var integer
     */
    private $type;

    /**
     * @param string  $name
     * @param integer $type Number::INTEGER or Number::FLOAT
     * @param string  $message
     */
    public function __construct($name, $type = Number::INTEGER, $message = ':name is an invalid number')
    {
        $this->type = $type;

        parent::__construct($name, $message);
    }

    /**
     * Return Number::INTEGER or Number::FLOAT
     *
     * @return integer
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param  mixed   $value
     * @return boolean
     */
    public function isValid($value)
    {
        switch ($this->type) {
            case self::INTEGER:
                return self::isValidInteger($value);

            case self::FLOAT:
                return self::isValidFloat($value);
        }

        return false;
    }
}
