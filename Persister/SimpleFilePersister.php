<?php

namespace Mkocztorz\DataUrlHandler\Persister;

use Mkocztorz\DataUrlHandler\DataUrl\ImageInterface;
use Mkocztorz\DataUrlHandler\Exception\SaveFileErrorException;
use Mkocztorz\DataUrlHandler\Persister\Options\FilePersisterOptions;
use Mkocztorz\DataUrlHandler\Persister\Options\FilePersisterOptionsInterface;
use Mkocztorz\DataUrlHandler\Persister\Options\PersisterOptionsInterface;

/**
 * Filesystem persister using file_put_contents method.
 * Pros:
 *  - gd not involved
 *
 * Cons:
 *  - image data not verified - anything decoded from dataurl will be saved into given file
 *
 * Class SimpleFilePersister
 * @package Mkocztorz\DataUrlHandler\Persister
 */
class SimpleFilePersister extends FilesystemPersister
{
    /**
     * @param ImageInterface $image
     * @param PersisterOptionsInterface $persisterOptions
     * @return bool
     */
    public function save(ImageInterface $image, PersisterOptionsInterface $persisterOptions)
    {
        /** @var FilePersisterOptions $persisterOptions */
        $this->guardAgainstInvalidOptionsType($persisterOptions);
        $filePath = $persisterOptions->getFilePath();
        $this->guardAgainstInvalidPath($filePath);

        if (file_put_contents($filePath, $image->getData()) === false) {
            $msg = sprintf("Error saving file %s", $filePath);
            throw new SaveFileErrorException($msg, SaveFileErrorException::CANT_SAVE_FILE);
        }

        return true;
    }
}