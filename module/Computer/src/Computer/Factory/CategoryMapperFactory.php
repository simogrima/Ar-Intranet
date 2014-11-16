<?php


namespace Computer\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Computer\Mapper\CategoryMapper;

/**
 * Factory to create a category mapper
 */
class CategoryMapperFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /* @var \Computer\Options\ModuleOptions $moduleOptions */
        $moduleOptions = $serviceLocator->get('Computer\Options\ModuleOptions');
       
        $entityManager = $serviceLocator->get('doctrine.entitymanager.orm_default');
        
        /* @var \Computer\Mapper\CategoryMapper $mapper */
        $mapper = new CategoryMapper($entityManager);
        
        $mapper->setModuleOptions($moduleOptions);
        return $mapper;     
    }
}
