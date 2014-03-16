<?php

namespace CL\Carpo\Assert;

use CL\Carpo\Error;

/**
 * @author    Ivan Kerin <ikerin@gmail.com>
 * @copyright (c) 2014 Clippings Ltd.
 * @license   http://spdx.org/licenses/BSD-3-Clause
 */
class Number extends AbstractAssertion
{
    const INTEGER = 1;
    const FLOAT = 2;

    /**
     * @param  integer  $type  Number::INTEGER or Number::FLOAT
     * @param  string  $value
     * @return boolean
     */
    public static function isValid($type, $value)
    {
        switch ($type) {
            case self::INTEGER:
                return ctype_digit($value);

            case self::FLOAT:
                return is_numeric($value);
        }
    }

    /**
     * @var string
     */
    protected $message;

    /**
     * @var integer
     */
    protected $type;

    /**
     * @param string  $name
     * @param integer $type
     * @param string  $message
     */
    public function __construct($name, $type = Number::INTEGER, $message = null)
    {
        $this->type = $type;

        $message = $message ?: dgettext(Error::DOMAIN, '%s is an invalid number');

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
     * @param  object|array $subject
     * @return Error|null
     */
    public function execute($object)
    {
        if ($this->issetProperty($object)) {
            $value = $this->getProperty($object);

            if (! self::isValid($this->getType(), $value)) {
                return new Error($this->getMessage(), $this->getName());
            }
        }
    }
}