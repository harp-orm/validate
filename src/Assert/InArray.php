<?php

namespace CL\Carpo\Assert;

use CL\Carpo\Error;
use InvalidArgumentException;

/**
 * @author     Ivan Kerin
 * @copyright  (c) 2014 Clippings Ltd.
 * @license    http://www.opensource.org/licenses/isc-license.txt
 */
class InArray extends AbstractAssertion
{
    protected $array;
    protected $message = '%s is invalid';

    public function __construct($name, array $array, $message = null)
    {
        if (empty($array)) {
            throw new InvalidArgumentException('Array should not be empty');
        }

        $this->array = $array;

        parent::__construct($name, $message);
    }

    public function getArray()
    {
        return $this->array;
    }

    public function execute($object)
    {
        if ($this->issetProperty($object)) {
            $value = $this->getProperty($object);

            if (! in_array($value, $this->array)) {
                return new Error($this->getMessage(), $this->getName());
            }
        }
    }
}
