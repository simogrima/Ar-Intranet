<?php


namespace Computer\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Computer\Mapper\ComputerMapper;

/**
 * Factory to create a computer mapper
 */
class ComputerMapperFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /* @var \Computer\Options\ModuleOptions $moduleOptions */
        $moduleOptions = $serviceLocator->get('Computer\Options\ModuleOptions');
       
        $entityManager = $serviceLocator->get('doctrine.entitymanager.orm_default');
        
        /* @var \Computer\Mapper\ComputerMapper $mapper */
        $mapper = new ComputerMapper($entityManager);
        
        $mapper->setModuleOptions($moduleOptions);
        return $mapper;     
    }
}
