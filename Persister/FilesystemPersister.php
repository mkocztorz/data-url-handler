<?php

namespace Mkocztorz\DataUrlHandler\Persister;

use Mkocztorz\DataUrlHandler\Exception\SaveFileErrorException;
use Mkocztorz\DataUrlHandler\Persister\Options\FilePersisterOptions;
use Mkocztorz\DataUrlHandler\Persister\Options\PersisterOptionsInterface;

/**
 * Base class for file system persisters.
 *
 * Class FilesystemPersister
 * @package Mkocztorz\DataUrlHandler\Persister
 */
abstract class FilesystemPersister extends ImagePersister
{
    protected function guardAgainstInvalidPath($filePath)
    {
        $dir = dirname($filePath);
        if (!is_dir($dir)) {
            $msg = sprintf("%s is not a directory", $dir);
            throw new SaveFileErrorException($msg, SaveFileErrorException::DIRECTORY_NOT_EXISTS);
        }

        if (!is_writable($dir)) {
            $msg = sprintf("%s is not writable", $dir);
            throw new SaveFileErrorException($msg, SaveFileErrorException::DIRECTORY_NOT_WRITABLE);
        }

        if (is_file($filePath)) {
            $msg = sprintf("File %s already exists", $filePath);
            throw new SaveFileErrorException($msg, SaveFileErrorException::FILE_ALREADY_EXISTS);
        }
    }

    /**
     * @var string
     */
    protected $persisterOptionsClassName = '\Mkocztorz\DataUrlHandler\Persister\Options\FilePersisterOptions';

    /**
     * @param PersisterOptionsInterface $persisterOptions
     * @return bool
     */
    protected function testOptionsType(PersisterOptionsInterface $persisterOptions)
    {
        return $persisterOptions instanceof FilePersisterOptions;
    }
}
