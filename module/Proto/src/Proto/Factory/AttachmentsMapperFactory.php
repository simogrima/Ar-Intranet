<?php


namespace Proto\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Proto\Mapper\AttachmentsMapper;

/**
 * Factory to create a attachment mapper
 */
class AttachmentsMapperFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /* @var \Proto\Options\ModuleOptions $moduleOptions */
        $moduleOptions = $serviceLocator->get('Proto\Options\ModuleOptions');
       
        $entityManager = $serviceLocator->get('doctrine.entitymanager.orm_default');
        
        /* @var \Proto\Mapper\AttachmentsMapper $mapper */
        $mapper = new AttachmentsMapper($entityManager);
        
        $mapper->setModuleOptions($moduleOptions);
        return $mapper;     
    }
}
