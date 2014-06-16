<?php


namespace MyZfcRbac\Factory\Controller;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use MyZfcRbac\Controller\RoleController;

/**
 * Factory to create a role controller
 */
class RoleControllerFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /* @var $serviceLocator \Zend\Mvc\Controller\ControllerManager */
        $sm   = $serviceLocator->getServiceLocator();
        $options = $sm->get('MyZfcRbac\Options\ModuleOptions');
        $mapper = $sm->get('MyZfcRbac\Mapper\RoleMapper');
        
        return new RoleController($options, $mapper);
    }
}
