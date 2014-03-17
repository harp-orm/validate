Carpo
=====

[![Build Status](https://travis-ci.org/clippings/carpo.png?branch=master)](https://travis-ci.org/clippings/carpo)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/clippings/carpo/badges/quality-score.png?s=6e7541ce4d093a04ab800e34ac8c3135f7310ee2)](https://scrutinizer-ci.com/g/clippings/carpo/)
[![Code Coverage](https://scrutinizer-ci.com/g/clippings/carpo/badges/coverage.png?s=bbf3d9afdb04d93f2492a0b83ded665c9362ea7b)](https://scrutinizer-ci.com/g/clippings/carpo/)
[![Latest Stable Version](https://poser.pugx.org/clippings/carpo/v/stable.png)](https://packagist.org/packages/clippings/carpo)

Carpo is a validation library. It generates errors for objects based on a predefined assertions.

Quick Example:

```php
use CL\Carpo\Assert;
use CL\Carpo\Asserts;

$asserts = new Asserts(array(
    new Assert\Present('title'),
    new Assert\LengthBetween('title', 20, 100),
    new Assert\Email('newsletter_email'),
));

$subject = new stdClass();
$subject->title = 'small title';
$subject->newsletter_email = 'invalid email';

// title should be between 10 and 20 letters, newsletter_email should be a valid email
echo $asserts->validate($subject);
```

You can use both arrays and objects for subjects.

```php
$subject = array(
    'title' => 'small title',
    'newsletter_email' => 'invalid email',
);

echo $asserts->validate($subject);
```

Errors
------

The result of ``$asserts->validate($subject)`` is actually an ``Errors`` object. It's an Iterator that holds all the erorrs and has ``->humanize()`` mehtod to display all the errors.
You can also foreach it and get all the errors separately. Casting it to string calls ``->humanize()`` automatically.

```php
$errors = $asserts->validate($subject);

foreach($errors => $error) {
    echo $error->getName();
    echo $error->getFullMessage();
}
```
Available Asserts
-----------------

__Present__

Assert if the value is empty

```php
new Present('title'),
new Present('title', 'some custom message if needed'),
```

__Email__

Assert if the value is not a proper email address. By default it uses ``Email::NORMAL`` - a small and fast regex which should handle most cases.
If you need to validate unusual email addresses you can use ``Email::STRICT``. It will then use a slower but more comprehensive check.

```php
new Email('email_address'),
new Email('email_address', Email::STRICT),
new Email('email_address', Email::NORMAL, 'custom message'),
```

__InArray__

Assert if the value is present in an array, uses a simple ``in_array`` call. Will throw InvalidArgumentException if the array is empty.

```php
new InArray('state', array('big', 'small')),
new InArray('state', array('big', 'small'), 'some custom message'),
```

__URL__

Assert if the value is a valid url. By default it uses ``URL::NORMAL`` which converts all UTF related charecters in the url to their proper encoding. It also will convert non-ASCII domain names, using "idn" if the "intl" extension is available. This is similar to what browsers normally do.
If you want to use a more strict definition or URLs, stright from the RFC - you can use ``URL::STRICT`` - then it directly uses php's ``filter_var()`` method.

```php
new URL('website'),
new URL('website', URL::STRICT),
new URL('website', URL::NORMAL, 'some custom message'),
```

__Number__

Assert that the value is a number. By default only integers are allowed (``Number::INTEGER``). If you want to check for floats you can use ``Number::FLOAT``.

```php
new Number('quantity'),
new Number('frequency', Number::FLOAT),
new Number('quantity', Number::INTEGER, 'some custom message'),
```

__RegEx__

Assert that the value matches a given regex. Passed directly to ``preg_match()``

```php
new RegEx('card_number', '/\d{20}/'),
new RegEx('card_number', '/\d{20}/', 'some custom message'),
```

__LengthEquals__

Assert that the value is of exact string length. Uses ``mb_strlen()`` internally.

```php
new LengthEquals('name', 20),
new LengthEquals('name', 20, 'some custom message'),
```

__LengthGreaterThan__

Assert that the value's string length is longer than a set length. Uses ``mb_strlen()`` internally.

```php
new LengthGreaterThan('name', 20),
new LengthGreaterThan('name', 20, 'some custom message'),
```

__LengthLessThan__

Assert that the value's string length is shorter than a set length. Uses ``mb_strlen()`` internally.

```php
new LengthLessThan('name', 20),
new LengthLessThan('name', 20, 'some custom message'),
```

__LengthBetween__

Assert that the value's string length is between two set lengths (including). Uses ``mb_strlen()`` internally.

```php
new LengthLessThan('name', 10, 200),
new LengthLessThan('name', 10, 200, 'some custom message'),
```

__IP__

Assert that the value's is a valid IP address uses ``filter_var()`` internally

```php
new IP('last_login_ip'),
new IP('last_login_ip', 'some custom message'),
```

__Callback__

Assert that the result of a given callback is true. You can thus use php's native validation functions. It only passes the value to the method.

```php
new Callback('names', 'is_array'),
new Callback('names', array('MyClass', 'validation_method')),
new Callback('state', function($value){
    return $value !== 'test';
}),
```

## License

Copyright (c) 2014, Clippings Ltd. Developed by Ivan Kerin as part of [clippings.com](http://clippings.com)

Under BSD-3-Clause license, read LICENSE file.
