<?php

namespace Mkocztorz\DataUrlHandler\Persister;

use Mkocztorz\DataUrlHandler\DataUrl\ImageInterface;
use Mkocztorz\DataUrlHandler\Exception\SaveInEntityErrorException;
use Mkocztorz\DataUrlHandler\Persister\Options\EntityPersisterOptions;
use Mkocztorz\DataUrlHandler\Persister\Options\PersisterOptionsInterface;

class EntityPersister extends ImagePersister
{
    /**
     * @var string
     */
    protected $persisterOptionsClassName = '\Mkocztorz\DataUrlHandler\Persister\Options\EntityOptionsInterface';

    /**
     * @param PersisterOptionsInterface $persisterOptions
     * @return bool
     */
    protected function testOptionsType(PersisterOptionsInterface $persisterOptions)
    {
        return $persisterOptions instanceof EntityPersisterOptions;
    }

    /**
     * @param ImageInterface $image
     * @param PersisterOptionsInterface $persisterOptions
     * @return bool
     */
    public function save(ImageInterface $image, PersisterOptionsInterface $persisterOptions)
    {
        /** @var EntityPersisterOptions $persisterOptions */
        $this->guardAgainstInvalidOptionsType($persisterOptions);

        $entity = $persisterOptions->getEntity();
        $setter = $persisterOptions->getSetter();

        $this->guardAgainstUncallableSetter($entity, $setter);

        $entity->$setter($image->getData());

        return true;
    }

    /**
     * @param $entity
     * @param $setter
     */
    protected function guardAgainstUncallableSetter($entity, $setter)
    {
        if (!is_callable(array($entity, $setter))) {
            $msg = sprintf("The setter %s is not callable", $setter);
            throw new SaveInEntityErrorException($msg, SaveInEntityErrorException::SETTER_NOT_FOUND);
        }
    }
}
