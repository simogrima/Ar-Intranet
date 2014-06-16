<?php

namespace MyZfcRbac\Options;
use Zend\Stdlib\AbstractOptions;

/**
 * Extend ZfcRbac module options
 */
class ModuleOptions extends AbstractOptions
{
    /**
     * Array of data to show in the permission list
     * Key = Label in the list
     * Value = entity property(expecting a 'getProperty())
     */
    protected $permissionListElements = array('Id' => 'id', 'Name' => 'name');
    
    /**
     * Array of data to show in the permission list
     * Key = Label in the list
     * Value = entity property(expecting a 'getProperty())
     */
    protected $roleListElements = array('Id' => 'id', 'Name' => 'name');    
    
    /**
     * @var string
     */
    protected $permissionEntityClass = 'MyZfcRbac\Entity\Permission';
    
    /**
     * @var string
     */
    protected $roleEntityClass = 'MyZfcRbac\Entity\FlatRole';    
    
    
    public function setPermissionListElements(array $listElements)
    {
        $this->permissionListElements = $listElements;
    }

    public function getPermissionListElements()
    {
        return $this->permissionListElements;
    }    
    
    public function setRoleListElements(array $listElements)
    {
        $this->permissionListElements = $listElements;
    }

    public function getRoleListElements()
    {
        return $this->permissionListElements;
    }      
    
    /**
     * set permission entity class name
     *
     * @param string $entityClass
     * @return ModuleOptions
     */
    public function setPermissionEntityClass($entityClass)
    {
        $this->permissionEntityClass = $entityClass;
        return $this;
    }

    /**
     * get permission entity class name
     *
     * @return string
     */
    public function getPermissionEntityClass()
    {
        return $this->permissionEntityClass;
    }
    
    /**
     * set role entity class name
     *
     * @param string $entityClass
     * @return ModuleOptions
     */
    public function setRoleEntityClass($entityClass)
    {
        $this->roleEntityClass = $entityClass;
        return $this;
    }

    /**
     * get permission entity class name
     *
     * @return string
     */
    public function getRoleEntityClass()
    {
        return $this->roleEntityClass;
    }    
}
