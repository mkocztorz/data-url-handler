<?php

namespace Mkocztorz\DataUrlHandler\Exception;

class SaveFileErrorException extends PersistErrorException
{
    const CANT_SAVE_FILE = 1;
    const DIRECTORY_NOT_EXISTS = 2;
    const DIRECTORY_NOT_WRITABLE = 3;
    const FILE_ALREADY_EXISTS = 4;
    const ERROR_CREATING_RESOURCE = 5;
    const UNSUPPORTED_TYPE = 6;
}