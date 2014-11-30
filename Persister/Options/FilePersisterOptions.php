<?php

namespace Mkocztorz\DataUrlHandler\Persister\Options;

class FilePersisterOptions extends PersisterOptions
{

    /**
     *
     * @param string $filePath
     * @param int $quality
     */
    public function __construct($filePath, $quality = 100)
    {
        $this->setOption('filePath', $filePath);
        $this->setOption('quality', $quality);
    }

    public function getFilePath()
    {
        return $this->getOption('filePath');
    }

    public function getQuality()
    {
        return $this->getOption('quality');
    }

    /**
     * Get quality for jpeg - integer from 0 to 100 (best).
     *
     * @return int
     */
    public function getQualityJpg()
    {
        $quality = (int)$this->getQuality();
        if ($quality < 0 || $quality > 100) {
            $quality = 100;
        }
        return $quality;
    }

    /**
     * Get quality for png - integer from 0 (best) to 9.
     * (better name would be compression, but GD uses 'quality' too)
     * @return int
     */
    public function getQualityPng()
    {
        //convert 0-100 to 0-10
        $compression = (int)floor((100 - (int)$this->getQualityJpg()) / 10);
        //convert 0-10 to 0-9
        if ($compression == 10) {
            $compression = 9;
        }
        return $compression;
    }
}