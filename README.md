Data-URL Image Handler
======================

Helps to validate and persist DataURL Image Data.

How image is persisted depends on selected implementation of PersisterInterface. 

Image persisters
----------------
There are several persisters bundled:

+ SimpleFilePersister

  saves data url into given file (no data validation)
  
+ FilePersister

  saves data url into given file using GD lib. Checks if data is valid image data and is consistent with file ext.

+ EntityPersister

  Invokes a method on given object passing decoded data.

Example
-------

```php
    use Mkocztorz\DataUrlHandler\DataUrl\Handler;
    use Mkocztorz\DataUrlHandler\Persister\Options\FilePersisterOptions;
    use Mkocztorz\DataUrlHandler\Persister\SimpleFilePersister;
    use Mkocztorz\DataUrlHandler\Tests\DataUrlSample;
    
    include 'vendor/autoload.php';
    
    $persister = new SimpleFilePersister();
    $handler = new Handler($persister);
    
    $fileOptions = new FilePersisterOptions("./image.png");
    
    $handler->handleImage(DataUrlSample::$validDataUrl, $fileOptions);
```