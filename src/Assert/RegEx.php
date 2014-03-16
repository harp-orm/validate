<?php

namespace CL\Carpo\Assert;

use CL\Carpo\Error;

/**
 * @author     Ivan Kerin
 * @copyright  (c) 2014 Clippings Ltd.
 * @license    http://www.opensource.org/licenses/isc-license.txt
 */
class RegEx extends AbstractAssertion
{
    protected $pattern;
    protected $message = '%s is invalid';

    public function __construct($name, $pattern, $message = null)
    {
        $this->pattern = (string) $pattern;

        parent::__construct($name, $message);
    }

    public function getPattern()
    {
        return $this->pattern;
    }

    public function execute($object)
    {
        if ($this->issetProperty($object)) {
            $value = $this->getProperty($object);

            if (! preg_match($this->pattern, $value)) {
                return new Error($this->getMessage(), $this->getName());
            }
        }
    }
}
