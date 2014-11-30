<?php

namespace Mkocztorz\DataUrlHandler;

use Mkocztorz\DataUrlHandler\DataUrl\Image;

class DataUrlHandler
{
    public function getImage($dataUrl)
    {
        return new Image($dataUrl);
    }
} 