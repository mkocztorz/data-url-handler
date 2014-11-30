<?php

namespace Mkocztorz\DataUrlHandler\Tests\DataUrl;

use Mkocztorz\DataUrlHandler\DataUrl\Image;
use Mkocztorz\DataUrlHandler\DataUrl\ImageInterface;
use Mkocztorz\DataUrlHandler\Persister\SimpleFilePersister;
use Mkocztorz\DataUrlHandler\Tests\DataUrlSample;
use PHPUnit_Framework_TestCase;

class ImageTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var string
     */
    protected $validDataUrl;

    public function setUp()
    {
        $this->validDataUrl = DataUrlSample::$validDataUrl;
    }

    public function testCreatingImageFromValidDataUrl()
    {
        $image = new Image($this->validDataUrl);
        $this->assertTrue($image instanceof ImageInterface);
        $this->assertTrue($image->getMimeType() === "image/png");
        $this->assertTrue($image->getData() === base64_decode(DataUrlSample::$payload));
    }

    /**
     * @expectedException \Mkocztorz\DataUrlHandler\Exception\InvalidDataUrlException
     * @expectedExceptionCode \Mkocztorz\DataUrlHandler\Exception\InvalidDataUrlException::DATA_URL_IS_NOT_A_STRING
     */
    public function testInvalidArgumentType()
    {
        new Image([]);
    }

    /**
     * @expectedException \Mkocztorz\DataUrlHandler\Exception\InvalidDataUrlException
     * @expectedExceptionCode \Mkocztorz\DataUrlHandler\Exception\InvalidDataUrlException::MALFORMED_DATA_URL
     */
    public function testMalformedDataUrl()
    {
        $malformed = "malformed data url";
        new Image($malformed);
    }

    /**
     * @expectedException \Mkocztorz\DataUrlHandler\Exception\InvalidDataUrlException
     * @expectedExceptionCode \Mkocztorz\DataUrlHandler\Exception\InvalidDataUrlException::DECLARED_MIMETYPE_NOT_ALLOWED
     */
    public function testInvalidMimeType()
    {
        $invalidMimeType = "data:text/plain;base64,iVBORw0KGgoAAAANSUhEUgAAAlgAAA";
        new Image($invalidMimeType);
    }


    /**
     * @expectedException \Mkocztorz\DataUrlHandler\Exception\InvalidDataUrlException
     * @expectedExceptionCode \Mkocztorz\DataUrlHandler\Exception\InvalidDataUrlException::FAILED_DECODING_DATA
     */
    public function testInvalidData()
    {
        $invalidData = "data:image/png;base64,╣==♀╔=";
        new Image($invalidData);
    }

    public function test()
    {
        new SimpleFilePersister();
    }

}
 