<?php

namespace Mkocztorz\DataUrlHandler\DataUrl;

interface ImageInterface
{
    /**
     * @return string
     */
    public function getMimeType();

    /**
     * @return string
     */
    public function getData();
}