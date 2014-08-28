<?php

namespace Harp\Validate\Assert;

use Harp\Validate\Error;

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
    private $matches;

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

    /**
     * @return string
     */
    public function getMatches()
    {
        return $this->matches;
    }

    /**
     * @return array
     */
    public function getMessageParameters()
    {
        return parent::getMessageParameters() + [
            ':matches' => $this->matches,
        ];
    }

    /**
     * @param  object     $subject
     * @return Error|null
     */
    public function getError($subject)
    {
        if (isset($subject->{$this->getName()}) and isset($subject->{$this->matches})) {
            $value = $subject->{$this->getName()};
            $matchValue = $subject->{$this->matches};

            if ($value != $matchValue) {
                return new Error($this);
            }
        }
    }
}
