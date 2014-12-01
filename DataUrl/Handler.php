<?php

namespace Mkocztorz\DataUrlHandler\DataUrl;

use Mkocztorz\DataUrlHandler\Persister\Options\PersisterOptionsInterface;
use Mkocztorz\DataUrlHandler\Persister\ImagePersisterInterface;

class Handler
{
    /**
     * @var ImagePersisterInterface
     */
    protected $persister;

    /**
     * @param ImagePersisterInterface $persister
     */
    public function __construct(ImagePersisterInterface $persister)
    {
        $this->persister = $persister;
    }

    /**
     * @param string $dataUrl
     * @param PersisterOptionsInterface $persisterOptions
     * @return bool
     */
    public function handleImage($dataUrl, PersisterOptionsInterface $persisterOptions)
    {
        try {
            $image = new Image($dataUrl);
            $this->persister->save($image, $persisterOptions);
            $success = true;
        } catch (\Exception $e) {
            $success = false;
        }

        return $success;
    }
}
