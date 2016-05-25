<?php


namespace Application\Factory\Controller;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Application\Controller\SuppliersController;

/**
 * Factory to create a suppliers controller
 */
class SuppliersControllerFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /* @var $serviceLocator \Zend\Mvc\Controller\ControllerManager */
        $sm   = $serviceLocator->getServiceLocator();
        $options = $sm->get('Application\Options\ModuleOptions');
        $mapper = $sm->get('Application\Mapper\SuppliersMapper');
        
        return new SuppliersController($options, $mapper);
    }
}
