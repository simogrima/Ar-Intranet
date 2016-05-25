<?php


namespace Prototyping\Factory\Controller;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Prototyping\Controller\AttachmentsController;

/**
 * Factory to create a attachments controller
 */
class AttachmentsControllerFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /* @var $serviceLocator \Zend\Mvc\Controller\ControllerManager */
        $sm   = $serviceLocator->getServiceLocator();
        $options = $sm->get('Prototyping\Options\ModuleOptions');
        $mapper = $sm->get('Prototyping\Mapper\AttachmentsMapper');
        
        return new AttachmentsController($options, $mapper);
    }
}
