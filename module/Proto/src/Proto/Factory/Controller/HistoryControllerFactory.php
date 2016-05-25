<?php


namespace Proto\Factory\Controller;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Proto\Controller\HistoryController;

/**
 * Factory to create a history controller
 */
class HistoryControllerFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /* @var $serviceLocator \Zend\Mvc\Controller\ControllerManager */
        $sm   = $serviceLocator->getServiceLocator();
        $options = $sm->get('Proto\Options\ModuleOptions');
        $mapper = $sm->get('Proto\Mapper\HistoryMapper');
        
        return new HistoryController($options, $mapper);
    }
}
