<?php

namespace CL\Carpo\Assert;

use CL\Carpo\Error;

/**
 * @author     Ivan Kerin
 * @copyright  (c) 2014 Clippings Ltd.
 * @license    http://www.opensource.org/licenses/isc-license.txt
 */
class LengthEquals extends AbstractAssertion
{
    protected $length;
    protected $message = '%s should be %s letters';

    public function __construct($name, $length, $message = null)
    {
        $this->length = (int) $length;

        parent::__construct($name, $message);
    }

    public function getLength()
    {
        return $this->length;
    }

    public function execute($object)
    {
        if ($this->issetProperty($object)) {
            $value = $this->getProperty($object);
            $length = mb_strlen($value, mb_detect_encoding($value));

            if ($length != $this->length) {
                return new Error($this->getMessage(), $this->getName(), $this->length);
            }
        }
    }
}
