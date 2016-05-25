<?php

namespace Application\Options;

use Zend\Stdlib\AbstractOptions;

class ModuleOptions extends AbstractOptions
{
    /**
     * @var string
     */

    protected $suppliersEntityClass = 'Application\Entity\Supplier';

    /**
     * set suppliers entity class name
     *
     * @param string $entityClass
     * @return ModuleOptions
     */
    public function setSuppliersEntityClass($entityClass)
    {
        $this->suppliersEntityClass = $entityClass;
        return $this;
    }

    /**
     * get suppliers entity class name
     *
     * @return string
     */
    public function getSuppliersEntityClass()
    {
        return $this->suppliersEntityClass;
    }     

}
