<?php

namespace Harp\Validate;

use Harp\Harp\Repo\Event;

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
        self::getRepo()->dispatchBeforeEvent($this, Event::VALIDATE);
        $this->errors = $this->getValidationAsserts()->validate($this);
        self::getRepo()->dispatchAfterEvent($this, Event::VALIDATE);

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
            $exception = new InvalidException(sprintf('Has errors: %s', $this->getErrors()));
            $exception->setSubject($this);

            throw $exception;
        }

        return $this;
    }

    /**
     * @return boolean
     */
    public function isEmptyErrors()
    {
        return $this->errors ? $this->errors->isEmpty() : true;
    }
}
