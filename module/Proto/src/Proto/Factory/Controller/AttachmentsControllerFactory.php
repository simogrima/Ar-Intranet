<?php


namespace Proto\Factory\Controller;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Proto\Controller\AttachmentsController;

/**
 * Factory to create a attachments controller
 */
class AttachmentsControllerFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /* @var $serviceLocator \Zend\Mvc\Controller\ControllerManager */
        $sm   = $serviceLocator->getServiceLocator();
        $options = $sm->get('Proto\Options\ModuleOptions');
        $mapper = $sm->get('Proto\Mapper\AttachmentsMapper');
        
        return new AttachmentsController($options, $mapper);
    }
}
