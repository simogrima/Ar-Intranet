<?php


namespace Proto\Factory\Controller;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Proto\Controller\SuppliesController;

/**
 * Factory to create a supplies controller
 */
class SuppliesControllerFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /* @var $serviceLocator \Zend\Mvc\Controller\ControllerManager */
        $sm   = $serviceLocator->getServiceLocator();
        $options = $sm->get('Proto\Options\ModuleOptions');
        $mapper = $sm->get('Proto\Mapper\SuppliesMapper');
        
        return new SuppliesController($options, $mapper);
    }
}
