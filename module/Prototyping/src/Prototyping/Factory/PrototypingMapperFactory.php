<?php

namespace Prototyping\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Prototyping\Mapper\PrototypingMapper;

/**
 * Factory to create a prototyping mapper
 */
class PrototypingMapperFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /* @var \Prototyping\Options\ModuleOptions $moduleOptions */
        $moduleOptions = $serviceLocator->get('Prototyping\Options\ModuleOptions');
       
        $entityManager = $serviceLocator->get('doctrine.entitymanager.orm_default');
        
        /* @var \Prototyping\Mapper\PrototypingMapper $mapper */
        $mapper = new PrototypingMapper($entityManager);
        
        $mapper->setModuleOptions($moduleOptions);
        return $mapper;     
    }
}
