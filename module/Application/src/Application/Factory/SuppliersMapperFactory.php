<?php


namespace Application\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Application\Mapper\SuppliersMapper;

/**
 * Factory to create a suppliers mapper
 */
class SuppliersMapperFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /* @var \Application\Options\ModuleOptions $moduleOptions */
        $moduleOptions = $serviceLocator->get('Application\Options\ModuleOptions');
       
        $entityManager = $serviceLocator->get('doctrine.entitymanager.orm_default');
        
        /* @var \Application\Mapper\SuppliersMapper $mapper */
        $mapper = new SuppliersMapper($entityManager);
        
        $mapper->setModuleOptions($moduleOptions);
        return $mapper;     
    }
}
