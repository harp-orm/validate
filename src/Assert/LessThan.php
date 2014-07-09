<?php

namespace Harp\Validate\Assert;

use Harp\Validate\Error;

/**
 * Assert that a numeric value is smaller than a set value.
 *
 * @author    Ivan Kerin <ikerin@gmail.com>
 * @copyright (c) 2014 Clippings Ltd.
 * @license   http://spdx.org/licenses/BSD-3-Clause
 */
class LessThan extends AbstractAssertion
{
    /**
     * @var integer|float
     */
    protected $value;

    /**
     * @param string        $name
     * @param integer|float $value
     * @param string        $message
     */
    public function __construct($name, $value, $message = ':name should be less than :value')
    {
        $this->value = $value;

        parent::__construct($name, $message);
    }

    /**
     * @return integer|float
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param  object|array $subject
     * @return Error|null
     */
    public function execute($subject)
    {
        if ($this->issetProperty($subject, $this->getName())) {
            $value = $this->getProperty($subject, $this->getName());

            if ($value >= $this->value) {
                $parameters = [':value' => $this->value];

                return new Error($this->getMessage(), $this->getName(), $parameters);
            }
        }
    }
}
