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
            $this->errors = new Errors();
        }

        return $this->errors;
    }

    /**
     * @return boolean
     */
    public function validate()
    {
        $errors = $this->getValidationAsserts()->getErrors($this);

        $this->getErrors()->set($errors);

        return $this->isEmptyErrors();
    }

    /**
     * Throws an exception if invalid
     *
     * @return static
     * @throws InvalidException If has errors
     */
    public function assertValid()
    {
        if (! $this->validate()) {
            throw new InvalidException($this, $this->getErrors());
        }

        return $this;
    }

    /**
     * @return boolean
     */
    public function isEmptyErrors()
    {
        return $this->getErrors()->isEmpty();
    }
}
