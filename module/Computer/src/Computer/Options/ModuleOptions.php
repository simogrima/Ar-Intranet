<?php

namespace Computer\Options;

use Zend\Stdlib\AbstractOptions;

class ModuleOptions extends AbstractOptions
{

    /**
     * @var string
     */
    protected $sampleEntityClass = 'Computer\Entity\Computer';

    /**
     * set sample entity class name
     *
     * @param string $entityClass
     * @return ModuleOptions
     */
    public function setComputerEntityClass($entityClass)
    {
        $this->sampleClassEntityClass = $entityClass;
        return $this;
    }

    /**
     * get sample entity class name
     *
     * @return string
     */
    public function getComputerEntityClass()
    {
        return $this->sampleEntityClass;
    }

}
