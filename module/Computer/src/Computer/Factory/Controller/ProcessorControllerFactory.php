<?php


namespace Computer\Factory\Controller;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Computer\Controller\ProcessorController;

/**
 * Factory to create a processor controller
 */
class ProcessorControllerFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /* @var $serviceLocator \Zend\Mvc\Controller\ControllerManager */
        $sm   = $serviceLocator->getServiceLocator();
        $options = $sm->get('Computer\Options\ModuleOptions');
        $mapper = $sm->get('Computer\Mapper\ProcessorMapper');
        
        return new ProcessorController($options, $mapper);
    }
}
