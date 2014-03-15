Env Backup
==========

[![Build Status](https://travis-ci.org/clippings/env-backup.png?branch=master)](https://travis-ci.org/clippings/env-backup)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/clippings/env-backup/badges/quality-score.png?s=5e12a9e615449e2b63cc5bae31fc92f6bb977ca4)](https://scrutinizer-ci.com/g/clippings/env-backup/)
[![Code Coverage](https://scrutinizer-ci.com/g/clippings/env-backup/badges/coverage.png?s=bf4be88c910271150acc5fb0ce2bd1d0585ea524)](https://scrutinizer-ci.com/g/clippings/env-backup/)
[![Latest Stable Version](https://poser.pugx.org/clippings/env-backup/v/stable.png)](https://packagist.org/packages/clippings/env-backup)

Backup/restore environment variables: globals and static vars

You can add "Parameters" to the environment, each "applying" and "restoring" a specific super global or static property of a class

 - `GlobalParam` - used for setting / restoring '\_POST', '\_GET', '\_FILES', '\_SERVER', '\_COOKIE' and '\_SESSION'
 - `ServerParam` - used specifically for '\_SERVER' super global so you can set / restore only some of its contents, e.g. REMOTE\_HOST', 'CLIENT\_IP ...
 - `StaticParam` - used for setting / restoring static properties of classes, it can handle protected and privete ones too.

Example:

```php
use CL\EnvBackup\Env;
use CL\EnvBackup\GlobalParam;
use CL\EnvBackup\ServerParam;
use CL\EnvBackup\StaticParam;

$env = new Env(array(
    new GlobalParam('_POST', array('new post name' => 'val')),
    new ServerParam('REMOTE_ADDR', '1.1.1.1'),
    new StaticParam('MyClass', 'private_var', 10)
));

// Do some stuff that changes / uses these variables
// ...

$env->restore();
```

## License

Copyright (c) 2014, Clippings Ltd. Developed by Ivan Kerin as part of [clippings.com](http://clippings.com)

Under BSD-3-Clause license, read LICENSE file.
