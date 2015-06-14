<?php


namespace Samples\Factory\Controller;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Samples\Controller\AttachmentsController;

/**
 * Factory to create a attachments controller
 */
class AttachmentsControllerFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /* @var $serviceLocator \Zend\Mvc\Controller\ControllerManager */
        $sm   = $serviceLocator->getServiceLocator();
        $options = $sm->get('Samples\Options\ModuleOptions');
        $mapper = $sm->get('Samples\Mapper\AttachmentsMapper');
        
        return new AttachmentsController($options, $mapper);
    }
}
