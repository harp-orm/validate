<?php

namespace CL\Carpo\Assert;

use CL\Carpo\Error;

/**
 * @author     Ivan Kerin
 * @copyright  (c) 2014 Clippings Ltd.
 * @license    http://www.opensource.org/licenses/isc-license.txt
 */
class URL extends AbstractAssertion
{
    protected $message = '%s should be a valid URL address';

    public static function isValid($url)
    {
        // Based on http://www.apps.ietf.org/rfc/rfc1738.html#sec-5
        $expression = '~^

            # scheme
            [-a-z0-9+.]++://

            # username:password (optional)
            (?:
                    [-a-z0-9$_.+!*\'(),;?&=%]++   # username
                (?::[-a-z0-9$_.+!*\'(),;?&=%]++)? # password (optional)
                @
            )?

            (?:
                # ip address
                \d{1,3}+(?:\.\d{1,3}+){3}+

                | # or

                # hostname (captured)
                (
                         (?!-)[-a-z0-9]{1,63}+(?<!-)
                    (?:\.(?!-)[-a-z0-9]{1,63}+(?<!-)){0,126}+
                )
            )

            # port (optional)
            (?::\d{1,5}+)?

            # path (optional)
            (?:/.*)?

            $~iDx';

        if (! preg_match($expression, $url, $matches)) {
            return false;
        }

        // We matched an IP address
        if (! isset($matches[1])) {
            return true;
        }

        // Check maximum length of the whole hostname
        // http://en.wikipedia.org/wiki/Domain_name#cite_note-0
        if (strlen($matches[1]) > 253) {
            return false;
        }

        // An extra check for the top level domain
        // It must start with a letter
        $tld = ltrim(substr($matches[1], (int) strrpos($matches[1], '.')), '.');

        return ctype_alpha($tld[0]);
    }

    public function execute($object)
    {
        if ($this->issetProperty($object))
        {
            $value = $this->getProperty($object);
            if (! self::isValid($value))
            {
                return new Error($this->getMessage(), $this->getName());
            }
        }
    }
}
