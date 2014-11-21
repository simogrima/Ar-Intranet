<?php


namespace Computer\Factory\Controller;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Computer\Controller\IndexController;

/**
 * Factory to create a index controller
 */
class IndexControllerFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /* @var $serviceLocator \Zend\Mvc\Controller\ControllerManager */
        $sm   = $serviceLocator->getServiceLocator();
        $options = $sm->get('Computer\Options\ModuleOptions');
        $mapper = $sm->get('Computer\Mapper\ComputerMapper');
        $mapperHistory = $sm->get('Computer\Mapper\HistoryMapper');
        
        return new IndexController($options, $mapper, $mapperHistory);
    }
}
