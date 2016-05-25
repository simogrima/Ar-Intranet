<?php


namespace Proto\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Proto\Mapper\SuppliesMapper;

/**
 * Factory to create a supplies mapper
 */
class SuppliesMapperFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /* @var \Proto\Options\ModuleOptions $moduleOptions */
        $moduleOptions = $serviceLocator->get('Proto\Options\ModuleOptions');
       
        $entityManager = $serviceLocator->get('doctrine.entitymanager.orm_default');
        
        /* @var \Proto\Mapper\SuppliesMapper $mapper */
        $mapper = new SuppliesMapper($entityManager);
        
        $mapper->setModuleOptions($moduleOptions);
        return $mapper;     
    }
}
