<?php

namespace Mkocztorz\DataUrlHandler\Persister;

use Mkocztorz\DataUrlHandler\DataUrl\ImageInterface;
use Mkocztorz\DataUrlHandler\Exception\SaveFileErrorException;
use Mkocztorz\DataUrlHandler\Persister\Options\FilePersisterOptions;
use Mkocztorz\DataUrlHandler\Persister\Options\PersisterOptionsInterface;

class FilePersister extends FilesystemPersister
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

        $handle = $this->getImageResourceHandle($image);

        $this->saveFile($handle, $persisterOptions);

        return true;
    }

    /**
     * @param ImageInterface $image
     * @return resource
     */
    protected function getImageResourceHandle(ImageInterface $image)
    {
        try {
            $handle = imagecreatefromstring($image->getData());
            $prevExc = null;
        } catch (\Exception $e) {
            $handle = false;
            $prevExc = $e;
        }
        if ($handle === false) {
            $msg = "Failed to create image from data string";
            throw new SaveFileErrorException($msg, SaveFileErrorException::ERROR_CREATING_RESOURCE, $prevExc);
        }

        return $handle;
    }

    /**
     * @param resource $handle
     * @param PersisterOptionsInterface $persisterOptions
     */
    protected function saveFile($handle, PersisterOptionsInterface $persisterOptions)
    {
        /** @var FilePersisterOptions $persisterOptions */
        $filePath = $persisterOptions->getFilePath();
        $ext = pathinfo($filePath, PATHINFO_EXTENSION);
        $knownExtensions = array('jpg', 'jpeg', 'png', 'gif');
        if (!in_array($ext, $knownExtensions)) {
            $msg = sprintf("Unsupported file extension '%s'", $ext);
            throw new SaveFileErrorException($msg, SaveFileErrorException::UNSUPPORTED_TYPE);
        }

        $prevException = null;
        try {
            switch ($ext) {
                case 'jpg':
                case 'jpeg':
                    $success = imagejpeg($handle, $filePath, $persisterOptions->getQualityJpg());
                    break;
                case 'png':
                    $success = imagepng($handle, $filePath, $persisterOptions->getQualityPng());
                    break;
                case 'gif':
                    $success = imagegif($handle, $filePath);
                    break;
                default:
                    $success = false;
                    break;
            }
        } catch (\Exception $e) {
            $prevException = $e;
            $success = false;
        }

        if (!$success) {
            throw new SaveFileErrorException("Can't save file", SaveFileErrorException::CANT_SAVE_FILE, $prevException);
        }
    }
}
