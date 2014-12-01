<?php

namespace Mkocztorz\DataUrlHandler\Persister;

use Mkocztorz\DataUrlHandler\DataUrl\ImageInterface;
use Mkocztorz\DataUrlHandler\Persister\Options\PersisterOptionsInterface;

interface ImagePersisterInterface
{
    /**
     * @param ImageInterface $image
     * @param PersisterOptionsInterface $persisterOptions
     *
     * @return boolean
     */
    public function save(ImageInterface $image, PersisterOptionsInterface $persisterOptions);
}
