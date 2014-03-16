<?php

namespace CL\Carpo\Assert;

use CL\Carpo\Error;

/**
 * @author     Ivan Kerin
 * @copyright  (c) 2014 Clippings Ltd.
 * @license    http://www.opensource.org/licenses/isc-license.txt
 */
class Number extends AbstractAssertion
{
    public static function isValid($type, $value)
    {
        switch ($type) {
            case self::INTEGER:
                return ctype_digit($value);

            case self::FLOAT:
                return is_numeric($value);
        }
    }

    const INTEGER = 1;
    const FLOAT = 2;

    protected $message = '%s is an invalid number';
    protected $type;

    public function __construct($name, $type = Number::INTEGER, $message = null)
    {
        $this->type = $type;

        parent::__construct($name, $message);
    }

    public function getType()
    {
        return $this->type;
    }

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
