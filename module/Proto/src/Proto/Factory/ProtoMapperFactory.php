<?php

namespace Proto\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Proto\Mapper\ProtoMapper;

/**
 * Factory to create a proto mapper
 */
class ProtoMapperFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /* @var \Proto\Options\ModuleOptions $moduleOptions */
        $moduleOptions = $serviceLocator->get('Proto\Options\ModuleOptions');
       
        $entityManager = $serviceLocator->get('doctrine.entitymanager.orm_default');
        
        /* @var \Proto\Mapper\ProtoMapper $mapper */
        $mapper = new ProtoMapper($entityManager);
        
        $mapper->setModuleOptions($moduleOptions);
        return $mapper;     
    }
}
