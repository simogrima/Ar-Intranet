<?php


namespace Computer\Factory\Controller;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Computer\Controller\HistoryController;

/**
 * Factory to create a history controller
 */
class HistoryControllerFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /* @var $serviceLocator \Zend\Mvc\Controller\ControllerManager */
        $sm   = $serviceLocator->getServiceLocator();
        $options = $sm->get('Computer\Options\ModuleOptions');
        $mapper = $sm->get('Computer\Mapper\HistoryMapper');
        
        return new HistoryController($options, $mapper);
    }
}
