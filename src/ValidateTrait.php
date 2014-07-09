<?php

namespace Harp\Validate;

/**
 * Add this trait to your object to make them "validateable"
 *
 * @author     Ivan Kerin <ikerin@gmail.com>
 * @copyright  (c) 2014 Clippings Ltd.
 * @license    http://spdx.org/licenses/BSD-3-Clause
 */
trait ValidateTrait
{
    /**
     * @return Asserts
     */
    abstract public function getValidationAsserts();

    /**
     * @var Errors
     */
    private $errors;

    /**
     * Get Errors, fillid in when you call "validate"
     *
     * @return Errors
     */
    public function getErrors()
    {
        if (! $this->errors) {
            $this->errors = new Errors($this);
        }

        return $this->errors;
    }

    /**
     * @return boolean
     */
    public function validate()
    {
        $this->errors = $this->getValidationAsserts()->validate($this);

        return $this->isEmptyErrors();
    }

    /**
     * @return boolean
     */
    public function isEmptyErrors()
    {
        return $this->errors ? $this->errors->isEmpty() : true;
    }
}
