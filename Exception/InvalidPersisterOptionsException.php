<?php

namespace Mkocztorz\DataUrlHandler\Exception;

use InvalidArgumentException;

class InvalidPersisterOptionsException extends InvalidArgumentException
{
    const INVALID_TYPE = 1;
}
