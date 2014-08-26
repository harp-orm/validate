<?php

namespace Harp\Validate;

use LogicException;

/**
 * @author     Ivan Kerin <ikerin@gmail.com>
 * @copyright  (c) 2014 Clippings Ltd.
 * @license    http://spdx.org/licenses/BSD-3-Clause
 */
class InvalidException extends LogicException
{
    /**
     * @var array|object
     */
    private $subject;

    /**
     * @param array|object $subject
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;

        return $this;
    }

    /**
     * @return array|object
     */
    public function getSubject()
    {
        return $this->subject;
    }
}
