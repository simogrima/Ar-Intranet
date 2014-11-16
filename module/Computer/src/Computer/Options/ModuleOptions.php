<?php

namespace Computer\Options;

use Zend\Stdlib\AbstractOptions;

class ModuleOptions extends AbstractOptions
{

    /**
     * @var string
     */
    protected $computerEntityClass = 'Computer\Entity\Computer';
    protected $statusEntityClass = 'Computer\Entity\Status';    
    protected $categoryEntityClass = 'Computer\Entity\Category'; 

    /**
     * set computer entity class name
     *
     * @param string $entityClass
     * @return ModuleOptions
     */
    public function setComputerEntityClass($entityClass)
    {
        $this->computerClassEntityClass = $entityClass;
        return $this;
    }

    /**
     * get computer entity class name
     *
     * @return string
     */
    public function getComputerEntityClass()
    {
        return $this->computerEntityClass;
    }
    
    /**
     * set status entity class name
     *
     * @param string $entityClass
     * @return ModuleOptions
     */
    public function setStatusEntityClass($entityClass)
    {
        $this->statusEntityClass = $entityClass;
        return $this;
    }

    /**
     * get status entity class name
     *
     * @return string
     */
    public function getStatusEntityClass()
    {
        return $this->statusEntityClass;
    }
    
    /**
     * set category entity class name
     *
     * @param string $entityClass
     * @return ModuleOptions
     */
    public function setCategoryEntityClass($entityClass)
    {
        $this->categoryEntityClass = $entityClass;
        return $this;
    }

    /**
     * get category entity class name
     *
     * @return string
     */
    public function getCategoryEntityClass()
    {
        return $this->categoryEntityClass;
    }    
}
