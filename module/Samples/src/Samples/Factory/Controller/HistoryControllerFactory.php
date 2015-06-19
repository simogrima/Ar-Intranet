<?php


namespace Samples\Factory\Controller;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Samples\Controller\HistoryController;

/**
 * Factory to create a history controller
 */
class HistoryControllerFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /* @var $serviceLocator \Zend\Mvc\Controller\ControllerManager */
        $sm   = $serviceLocator->getServiceLocator();
        $options = $sm->get('Samples\Options\ModuleOptions');
        $mapper = $sm->get('Samples\Mapper\HistoryMapper');
        
        return new HistoryController($options, $mapper);
    }
}
