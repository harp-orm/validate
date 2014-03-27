<?php

namespace CL\Carpo\Assert;

use CL\Carpo\Error;

/**
 * Assert if the value of one property is equal to the value of another
 *
 * @author    Ivan Kerin <ikerin@gmail.com>
 * @copyright (c) 2014 Clippings Ltd.
 * @license   http://spdx.org/licenses/BSD-3-Clause
 */
class Matches extends AbstractAssertion
{
    /**
     * @var string
     */
    protected $matches;

    /**
     * @param string $name
     * @param string $matches
     * @param string $message
     */
    public function __construct($name, $matches, $message = ':name must match :matches')
    {
        $this->matches = (string) $matches;

        parent::__construct($name, $message);
    }

    public function getMatches()
    {
        return $this->matches;
    }

    /**
     * @param  object|array $subject
     * @return Error|null
     */
    public function execute($subject)
    {
        if ($this->issetProperty($subject, $this->getName()) and $this->issetProperty($subject, $this->matches)) {

            $value = $this->getProperty($subject, $this->getName());
            $matchValue = $this->getProperty($subject, $this->matches);

            if ($value != $matchValue) {
                return new Error($this->getMessage(), $this->getName(), array(':matches' => $this->matches));
            }
        }
    }
}
