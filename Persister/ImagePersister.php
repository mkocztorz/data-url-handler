<?php

namespace Mkocztorz\DataUrlHandler\Persister;

use Mkocztorz\DataUrlHandler\Exception\InvalidPersisterOptionsException;
use Mkocztorz\DataUrlHandler\Persister\Options\PersisterOptionsInterface;

abstract class ImagePersister implements ImagePersisterInterface
{
    /**
     * @var string
     */
    protected $persisterOptionsClassName = '\Mkocztorz\DataUrlHandler\Persister\Options\PersisterOptionsInterface';

    /**
     * @param PersisterOptionsInterface $persisterOptions
     * @return bool
     */
    protected function testOptionsType(PersisterOptionsInterface $persisterOptions)
    {
        return $persisterOptions instanceof PersisterOptionsInterface;
    }

    /**
     * @param PersisterOptionsInterface $persisterOptions
     */
    protected function guardAgainstInvalidOptionsType(PersisterOptionsInterface $persisterOptions)
    {
        if (!($this->testOptionsType($persisterOptions))) {
            $given = get_class($persisterOptions);
            $msg = sprintf("Invalid options object type. Got %s but expected %s", $given, $this->persisterOptionsClassName);
            throw new InvalidPersisterOptionsException($msg, InvalidPersisterOptionsException::INVALID_TYPE);
        }
    }


}
