<?php

namespace Harp\Validate;

use LogicException;
use Exception;

/**
 * @author     Ivan Kerin <ikerin@gmail.com>
 * @copyright  (c) 2014 Clippings Ltd.
 * @license    http://spdx.org/licenses/BSD-3-Clause
 */
class InvalidException extends LogicException
{
    public function __construct($subject, $code = 0, Exception $previous = null)
    {
        $this->subject = $subject;

        parent::__construct("Has errors: {$subject->getErrors()->humanize()}", $code, $previous);
    }

    /**
     * @var ValidateTrait
     */
    private $subject;

    /**
     * @return ValidateTrait
     */
    public function getSubject()
    {
        return $this->subject;
    }

    public function getErrors()
    {
        return $this->subject->getErrors();
    }
}
