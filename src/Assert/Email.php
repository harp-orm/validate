<?php

namespace CL\Carpo\Assert;

use CL\Carpo\Error;

/**
 * Assert if the value is not a proper email address.
 * By default it uses Email::NORMAL - a small and fast regex which should handle most cases.
 * If you need to validate unusual email addresses you can use Email::STRICT.
 * It will then use a slower but more comprehensive check.
 *
 * @author    Ivan Kerin <ikerin@gmail.com>
 * @copyright (c) 2014 Clippings Ltd.
 * @license   http://spdx.org/licenses/BSD-3-Clause
 */
class Email extends AbstractAssertion
{
    const NORMAL = 1;
    const STRICT = 2;

    /**
     * Check if email is valid with a comprehensive, but slower regex
     *
     * @link http://www.iamcal.com/publish/articles/php/parsing_email/
     * @param  string  $email
     * @return boolean
     */
    public static function isValidStrict($email)
    {
        $qtext = '[^\\x0d\\x22\\x5c\\x80-\\xff]';
        $dtext = '[^\\x0d\\x5b-\\x5d\\x80-\\xff]';
        $atom  = '[^\\x00-\\x20\\x22\\x28\\x29\\x2c\\x2e\\x3a-\\x3c\\x3e\\x40\\x5b-\\x5d\\x7f-\\xff]+';
        $pair  = '\\x5c[\\x00-\\x7f]';

        $domainLiteral = "\\x5b($dtext|$pair)*\\x5d";
        $quotedString  = "\\x22($qtext|$pair)*\\x22";
        $subdomain     = "($atom|$domainLiteral)";
        $word           = "($atom|$quotedString)";
        $domain         = "$subdomain(\\x2e$subdomain)*";
        $localPart     = "$word(\\x2e$word)*";

        $expression     = "/^$localPart\\x40$domain$/D";

        return (bool) preg_match($expression, $email);
    }

    /**
     * Check if email is valid with a fast regex
     * @param  string  $email
     * @return boolean
     */
    public static function isValid($email)
    {
        $expression =
            '/^

            [-_a-z0-9\'+*$^&%=~!?{}]++
            (?:\.[-_a-z0-9\'+*$^&%=~!?{}]+)*+

            # domain part
            @

            # host name
            (?:(?![-.])[-a-z0-9.]+(?<![-.])

            # top level
            \.

            [a-z]{2,6}
            | # or
            \d{1,3}

            (?:\.\d{1,3}){3})

            $/iDx';

        return (bool) preg_match($expression, $email);
    }

    /**
     * @var string
     */
    protected $message;

    /**
     * @var integer
     */
    protected $type;

    public function __construct($name, $type = EMAIL::NORMAL, $message = ':name should be a valid email')
    {
        $this->type = $type;

        parent::__construct($name, $message);
    }

    /**
     * @return boolean
     */
    public function isStrict()
    {
        return $this->type == self::STRICT;
    }

    /**
     * @param  object|array $subject
     * @return Error|null
     */
    public function execute($subject)
    {
        if ($this->issetProperty($subject, $this->getName())) {
            $value = $this->getProperty($subject, $this->getName());

            if (! ($this->isStrict() ? self::isValidStrict($value) : self::isValid($value))) {
                return new Error($this->getMessage(), $this->getName());
            }
        }
    }
}
