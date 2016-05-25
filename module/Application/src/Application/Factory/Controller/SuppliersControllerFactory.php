<?php


namespace Prototyping\Factory\Controller;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Prototyping\Controller\HistoryController;

/**
 * Factory to create a history controller
 */
class HistoryControllerFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /* @var $serviceLocator \Zend\Mvc\Controller\ControllerManager */
        $sm   = $serviceLocator->getServiceLocator();
        $options = $sm->get('Prototyping\Options\ModuleOptions');
        $mapper = $sm->get('Prototyping\Mapper\HistoryMapper');
        
        return new HistoryController($options, $mapper);
    }
}
