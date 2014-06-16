<?php


namespace MyZfcRbac\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use MyZfcRbac\Mapper\RoleMapper;

/**
 * Factory to create a role mapper
 */
class RoleMapperFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /* @var \ZfcRbac\Options\ModuleOptions $moduleOptions */
        $moduleOptions = $serviceLocator->get('MyZfcRbac\Options\ModuleOptions');
       
        $entityManager = $serviceLocator->get('doctrine.entitymanager.orm_default');
        
        /* @var \MyZfcRbac\Mapper\RoleDoctrine $mapper */
        $mapper = new RoleMapper($entityManager);
        
        $mapper->setModuleOptions($moduleOptions);
        return $mapper;     
    }
}
