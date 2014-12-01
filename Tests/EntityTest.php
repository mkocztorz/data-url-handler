<?php
namespace Mkocztorz\DataUrlHandler\Tests;

class EntityTest {
    protected $dataUrl;

    /**
     * @param mixed $dataUrl
     * @return $this
     */
    public function setDataUrl($dataUrl)
    {
        $this->dataUrl = $dataUrl;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDataUrl()
    {
        return $this->dataUrl;
    }


}
