<?php


namespace Prototyping\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Prototyping\Mapper\HistoryMapper;

/**
 * Factory to create a history mapper
 */
class HistoryMapperFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /* @var \Prototyping\Options\ModuleOptions $moduleOptions */
        $moduleOptions = $serviceLocator->get('Prototyping\Options\ModuleOptions');
       
        $entityManager = $serviceLocator->get('doctrine.entitymanager.orm_default');
        
        /* @var \Prototyping\Mapper\HistoryMapper $mapper */
        $mapper = new HistoryMapper($entityManager);
        
        $mapper->setModuleOptions($moduleOptions);
        return $mapper;     
    }
}
