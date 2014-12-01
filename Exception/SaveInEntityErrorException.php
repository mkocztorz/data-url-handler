<?php

namespace Mkocztorz\DataUrlHandler\Exception;

class SaveInEntityErrorException extends PersistErrorException
{
    const SETTER_NOT_FOUND      = 1;
}
