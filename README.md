Carpo
=====

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

echo $asserts->validate($subject);

// Will output
// title should be between 10 and 20 letters, newsletter_email should be a valid email
```

## License

Copyright (c) 2014, Clippings Ltd. Developed by Ivan Kerin as part of [clippings.com](http://clippings.com)

Under BSD-3-Clause license, read LICENSE file.
