<?php

namespace Mkocztorz\DataUrlHandler\DataUrl;

use Mkocztorz\DataUrlHandler\Exception\InvalidDataUrlException;

class Image implements ImageInterface
{
    /**
     * @var string
     */
    protected $mimeType;

    /**
     * @var string
     */
    protected $data;

    /**
     * @var array
     */
    protected $allowedMimeTypes = array();

    public function __construct($dataUrl)
    {
        $this->setAllowedMimeTypes(array(
            'image/jpg',
            'image/jpeg',
            'image/png',
            'image/gif',
        ));
        $this->decode($dataUrl);
    }

    protected function decode($dataUrl)
    {
        $this->guardAgainstInvalidDataUrlArgumentType($dataUrl);

        $data = $this->parseDataUrl($dataUrl);

        $decodedData = base64_decode($data, true);
        $this->guardAgainstDecodeError($decodedData);
        $this->data = $decodedData;
    }

    /**
     * @param $dataUrl
     * @return string
     */
    protected function parseDataUrl($dataUrl)
    {
        $matches = array();
        $result = preg_match('/data:([^;]*);base64,(.*)/', $dataUrl, $matches);
        $this->guardAgainstMalformedDataUrl($result, $matches);

        $mimeType = $matches[1];
        $this->guardAgainstNotAllowedMimeType($mimeType);
        $this->mimeType = $mimeType;

        $matches[2] = str_replace(" ", "+", $matches[2]);
        return $matches[2];
    }

    /**
     * @param string $dataUrl
     */
    protected function guardAgainstInvalidDataUrlArgumentType($dataUrl)
    {
        if (!is_string($dataUrl)) {
            throw new InvalidDataUrlException("Data url passed to DataUrl\\Image is not a string", InvalidDataUrlException::DATA_URL_IS_NOT_A_STRING);
        }
    }

    /**
     * @param mixed $result
     * @param array $matches
     */
    protected function guardAgainstMalformedDataUrl($result, $matches)
    {
        if ($result === false || $result == 0) {
            throw new InvalidDataUrlException("Data url passed to DataUrl\\Image is malformed", InvalidDataUrlException::MALFORMED_DATA_URL);
        }
        if (!is_array($matches) || count($matches) !== 3) {
            throw new InvalidDataUrlException("Data url passed to DataUrl\\Image is malformed", InvalidDataUrlException::MALFORMED_DATA_URL);
        }
    }

    /**
     * @param $mimeType
     */
    protected function guardAgainstNotAllowedMimeType($mimeType)
    {
        if (!in_array($mimeType, $this->allowedMimeTypes)) {
            throw new InvalidDataUrlException(sprintf('Declared mime type (%s) is not allowed', $mimeType), InvalidDataUrlException::DECLARED_MIMETYPE_NOT_ALLOWED);
        }
    }

    /**
     * @return string
     */
    public function getMimeType()
    {
        return $this->mimeType;
    }

    /**
     * @return string
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param $decodedData
     */
    protected function guardAgainstDecodeError($decodedData)
    {
        if ($decodedData === false) {
            throw new InvalidDataUrlException("Failed decoding url data string", InvalidDataUrlException::FAILED_DECODING_DATA);
        }
    }

    /**
     * Set allowed mime types array.
     *
     * @param array $allowedMimeTypes
     * @return $this
     */
    public function setAllowedMimeTypes($allowedMimeTypes)
    {
        $this->allowedMimeTypes = $allowedMimeTypes;

        return $this;
    }

    /**
     * Add single mime type to allowed list.
     *
     * @param $mimeType
     */
    public function addAllowedMimeType($mimeType)
    {
        if (!in_array($mimeType, $this->allowedMimeTypes)) {
            $this->allowedMimeTypes[] = $mimeType;
        }
    }
}
