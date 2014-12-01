<?php

namespace Mkocztorz\DataUrlHandler\Persister\Options;

class EntityPersisterOptions extends PersisterOptions
{
    /**
     * @param $entity
     * @param string $setter
     */
    public function __construct($entity, $setter)
    {
        $this->setOption('entity', $entity);
        $this->setOption('setter', $setter);
    }

    public function getEntity()
    {
        return $this->getOption('entity');
    }

    public function getSetter()
    {
        return $this->getOption('setter');
    }
}
