<?php


namespace Proto\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Proto\Mapper\HistoryMapper;

/**
 * Factory to create a history mapper
 */
class HistoryMapperFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /* @var \Proto\Options\ModuleOptions $moduleOptions */
        $moduleOptions = $serviceLocator->get('Proto\Options\ModuleOptions');
       
        $entityManager = $serviceLocator->get('doctrine.entitymanager.orm_default');
        
        /* @var \Proto\Mapper\HistoryMapper $mapper */
        $mapper = new HistoryMapper($entityManager);
        
        $mapper->setModuleOptions($moduleOptions);
        return $mapper;     
    }
}
