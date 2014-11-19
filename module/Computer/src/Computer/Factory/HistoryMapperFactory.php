<?php


namespace Computer\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Computer\Mapper\HistoryMapper;

/**
 * Factory to create a history mapper
 */
class HistoryMapperFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /* @var \Computer\Options\ModuleOptions $moduleOptions */
        $moduleOptions = $serviceLocator->get('Computer\Options\ModuleOptions');
       
        $entityManager = $serviceLocator->get('doctrine.entitymanager.orm_default');
        
        /* @var \Computer\Mapper\HistoryMapper $mapper */
        $mapper = new HistoryMapper($entityManager);
        
        $mapper->setModuleOptions($moduleOptions);
        return $mapper;     
    }
}
