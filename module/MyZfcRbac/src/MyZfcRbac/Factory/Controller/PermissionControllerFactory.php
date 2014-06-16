<?php


namespace MyZfcRbac\Factory\Controller;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use MyZfcRbac\Controller\PermissionController;

/**
 * Factory to create a permission controller
 */
class PermissionControllerFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /* @var $serviceLocator \Zend\Mvc\Controller\ControllerManager */
        $sm   = $serviceLocator->getServiceLocator();
        $options = $sm->get('MyZfcRbac\Options\ModuleOptions');
        $mapper = $sm->get('MyZfcRbac\Mapper\PermissionMapper');
        
        return new PermissionController($options, $mapper);
    }
}
