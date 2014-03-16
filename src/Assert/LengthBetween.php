<?php

namespace CL\Carpo\Assert;

use CL\Carpo\Error;
use InvalidArgumentException;

/**
 * @author     Ivan Kerin
 * @copyright  (c) 2014 Clippings Ltd.
 * @license    http://www.opensource.org/licenses/isc-license.txt
 */
class LengthBetween extends AbstractAssertion
{
    protected $min;
    protected $max;
    protected $message = '%s should be between %s and %s letters';

    public function __construct($name, $min, $max, $massage = null)
    {
        if ($min >= $max) {
            throw new InvalidArgumentException('Min should be less than max');
        }

        $this->min = (int) $min;
        $this->max = (int) $max;

        parent::__construct($name, $massage);
    }

    public function getMin()
    {
        return $this->min;
    }

    public function getMax()
    {
        return $this->max;
    }

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
