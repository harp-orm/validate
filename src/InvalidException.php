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
    /**
     * @param object    $subject
     * @param Errors    $errors
     * @param integer   $code
     * @param Exception $previous
     */
    public function __construct($subject, Errors $errors, $code = 0, Exception $previous = null)
    {
        $this->subject = $subject;
        $this->errors = $errors;

        parent::__construct("Has errors: {$errors->humanize()}", $code, $previous);
    }

    /**
     * @var object
     */
    private $subject;

    /**
     * @var Errors
     */
    private $errors;

    /**
     * @return object
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * @return Errors
     */
    public function getErrors()
    {
        return $this->errors;
    }
}
