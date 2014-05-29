<?php

namespace Harp\Validate\Assert;

use Harp\Validate\Error;

/**
 * Will trigger an error if the value is empty
 *
 * @author    Ivan Kerin <ikerin@gmail.com>
 * @copyright (c) 2014 Clippings Ltd.
 * @license   http://spdx.org/licenses/BSD-3-Clause
 */
class Present extends AbstractAssertion
{
    /**
     * @param string $name
     * @param string $message
     */
    public function __construct($name, $message = ':name must be present')
    {
        parent::__construct($name, $message);
    }

    public static function isValid($value)
    {
        return ($value !== null and $value !== false and $value !== '');
    }

    /**
     * @param  object|array $subject
     * @return Error|null
     */
    public function execute($subject)
    {
        if (! $this->issetProperty($subject, $this->getName())
            or ! self::isValid($this->getProperty($subject, $this->getName()))) {
            return new Error($this->getMessage(), $this->getName());
        }
    }
}
