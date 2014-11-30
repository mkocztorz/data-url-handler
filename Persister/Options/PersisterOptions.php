<?php

namespace Mkocztorz\DataUrlHandler\Persister\Options;


class PersisterOptions implements PersisterOptionsInterface
{
    /**
     * @var array
     */
    protected $options = [];

    protected function setOption($name, $value)
    {
        $this->options[$name] = $value;
    }

    public function getOption($name)
    {
        return $this->options[$name];
    }

} 