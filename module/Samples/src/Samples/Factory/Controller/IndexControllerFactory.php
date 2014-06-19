<?php


namespace Samples\Factory\Controller;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Samples\Controller\IndexController;

/**
 * Factory to create a index controller
 */
class IndexControllerFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /* @var $serviceLocator \Zend\Mvc\Controller\ControllerManager */
        $sm   = $serviceLocator->getServiceLocator();
        $options = $sm->get('Samples\Options\ModuleOptions');
        $mapper = $sm->get('Samples\Mapper\SampleMapper');
        
        return new IndexController($options, $mapper);
    }
}
