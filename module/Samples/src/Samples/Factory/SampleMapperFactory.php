<?php


namespace Samples\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Samples\Mapper\SampleMapper;

/**
 * Factory to create a sample mapper
 */
class SampleMapperFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /* @var \Samples\Options\ModuleOptions $moduleOptions */
        $moduleOptions = $serviceLocator->get('Samples\Options\ModuleOptions');
       
        $entityManager = $serviceLocator->get('doctrine.entitymanager.orm_default');
        
        /* @var \Samples\Mapper\SampleMapper $mapper */
        $mapper = new SampleMapper($entityManager);
        
        $mapper->setModuleOptions($moduleOptions);
        return $mapper;     
    }
}
