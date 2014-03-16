<?php

namespace CL\Carpo\Assert;

use CL\Carpo\Error;

/**
 * @author    Ivan Kerin <ikerin@gmail.com>
 * @copyright (c) 2014 Clippings Ltd.
 * @license   http://spdx.org/licenses/BSD-3-Clause
 */
class LengthLessThan extends AbstractAssertion
{
    /**
     * @var integer
     */
    protected $length;

    /**
     * @param string  $name
     * @param integer $length
     * @param string  $message
     */
    public function __construct($name, $length, $message = null)
    {
        $this->length = (int) $length;

        $message = $message ?: dgettext(Error::DOMAIN, '%s should be less than %s letters');

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
     * @param  object|array $subject
     * @return Error|null
     */
    public function execute($object)
    {
        if ($this->issetProperty($object)) {
            $value = $this->getProperty($object);
            $length = mb_strlen($value, mb_detect_encoding($value));

            if ($length >= $this->length) {
                return new Error($this->getMessage(), $this->getName(), $this->length);
            }
        }
    }
}
