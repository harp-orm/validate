<?php

namespace Harp\Validate\Assert;

use Harp\Validate\Error;
use Harp\Validate\Subject;

/**
 * Will trigger an error if the value is empty
 *
 * @author    Ivan Kerin <ikerin@gmail.com>
 * @copyright (c) 2014 Clippings Ltd.
 * @license   http://spdx.org/licenses/BSD-3-Clause
 */
class Present extends AbstractAssertion
{
    public static function isValue($value)
    {
        return ($value !== null and $value !== false and $value !== '');
    }

    /**
     * @param string $name
     * @param string $message
     */
    public function __construct($name, $message = ':name must be present')
    {
        parent::__construct($name, $message);
    }

    /**
     * @param  object     $subject
     * @return Error|null
     */
    public function getError($subject)
    {
        if (! isset($subject->{$this->getName()}) or ! self::isValue($subject->{$this->getName()})) {
            return new Error($this);
        }
    }
}
