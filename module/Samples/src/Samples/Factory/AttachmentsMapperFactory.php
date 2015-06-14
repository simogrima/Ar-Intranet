<?php


namespace Samples\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Samples\Mapper\AttachmentsMapper;

/**
 * Factory to create a sample mapper
 */
class AttachmentsMapperFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /* @var \Samples\Options\ModuleOptions $moduleOptions */
        $moduleOptions = $serviceLocator->get('Samples\Options\ModuleOptions');
       
        $entityManager = $serviceLocator->get('doctrine.entitymanager.orm_default');
        
        /* @var \Samples\Mapper\AttachmentsMapper $mapper */
        $mapper = new AttachmentsMapper($entityManager);
        
        $mapper->setModuleOptions($moduleOptions);
        return $mapper;     
    }
}
