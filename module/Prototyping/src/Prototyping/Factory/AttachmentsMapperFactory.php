<?php


namespace Prototyping\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Prototyping\Mapper\AttachmentsMapper;

/**
 * Factory to create a attachment mapper
 */
class AttachmentsMapperFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /* @var \Prototyping\Options\ModuleOptions $moduleOptions */
        $moduleOptions = $serviceLocator->get('Prototyping\Options\ModuleOptions');
       
        $entityManager = $serviceLocator->get('doctrine.entitymanager.orm_default');
        
        /* @var \Prototyping\Mapper\AttachmentsMapper $mapper */
        $mapper = new AttachmentsMapper($entityManager);
        
        $mapper->setModuleOptions($moduleOptions);
        return $mapper;     
    }
}
