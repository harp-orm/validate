<?php

namespace Harp\Validate\Assert;

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
class EmailStrict extends AbstractValueAssertion
{
    public function __construct($name, $message = ':name should be a valid email')
    {
        parent::__construct($name, $message);
    }

    /**
     * @param  mixed   $value
     * @return boolean
     */
    public function isValid($value)
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

        return (bool) preg_match($expression, $value);
    }
}
