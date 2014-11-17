<?php


namespace Computer\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Computer\Mapper\ProcessorMapper;

/**
 * Factory to create a processor mapper
 */
class ProcessorMapperFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /* @var \Computer\Options\ModuleOptions $moduleOptions */
        $moduleOptions = $serviceLocator->get('Computer\Options\ModuleOptions');
       
        $entityManager = $serviceLocator->get('doctrine.entitymanager.orm_default');
        
        /* @var \Computer\Mapper\ProcessorMapper $mapper */
        $mapper = new ProcessorMapper($entityManager);
        
        $mapper->setModuleOptions($moduleOptions);
        return $mapper;     
    }
}
