<?php

namespace Mkocztorz\DataUrlHandler\Exception;

use InvalidArgumentException;

class InvalidDataUrlException extends InvalidArgumentException
{
    const DATA_URL_IS_NOT_A_STRING = 1;
    const MALFORMED_DATA_URL = 2;
    const DECLARED_MIMETYPE_NOT_ALLOWED = 3;
    const FAILED_DECODING_DATA = 4;
}