<?php

namespace CL\Carpo\Assert;

use CL\Carpo\Error;
use InvalidArgumentException;

/**
 * @author    Ivan Kerin <ikerin@gmail.com>
 * @copyright (c) 2014 Clippings Ltd.
 * @license   http://spdx.org/licenses/BSD-3-Clause
 */
class LengthBetween extends AbstractAssertion
{
    /**
     * @var integer
     */
    protected $min;

    /**
     * @var integer
     */
    protected $max;

    /**
     * @param string  $name
     * @param integer $min
     * @param integer $max
     * @param string  $message
     */
    public function __construct($name, $min, $max, $message = null)
    {
        if ($min >= $max) {
            throw new InvalidArgumentException('Min should be less than max');
        }

        $this->min = (int) $min;
        $this->max = (int) $max;

        $message = $message ?: dgettext(Error::DOMAIN, '%s should be between %s and %s letters');

        parent::__construct($name, $message);
    }

    /**
     * @return integer
     */
    public function getMin()
    {
        return $this->min;
    }

    /**
     * @return integer
     */
    public function getMax()
    {
        return $this->max;
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

            if ($length < $this->min || $length > $this->max) {
                return new Error($this->getMessage(), $this->getName(), $this->min, $this->max);
            }
        }
    }
}
