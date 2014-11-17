<?php


namespace Computer\Factory\Controller;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Computer\Controller\BrandController;

/**
 * Factory to create a brand controller
 */
class BrandControllerFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /* @var $serviceLocator \Zend\Mvc\Controller\ControllerManager */
        $sm   = $serviceLocator->getServiceLocator();
        $options = $sm->get('Computer\Options\ModuleOptions');
        $mapper = $sm->get('Computer\Mapper\BrandMapper');
        
        return new BrandController($options, $mapper);
    }
}
