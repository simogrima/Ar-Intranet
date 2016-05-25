<?php


namespace Prototyping\Factory\Controller;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Prototyping\Controller\IndexController;

/**
 * Factory to create a index controller
 */
class IndexControllerFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /* @var $serviceLocator \Zend\Mvc\Controller\ControllerManager */
        $sm   = $serviceLocator->getServiceLocator();
        $options = $sm->get('Prototyping\Options\ModuleOptions');
        $mapper = $sm->get('Prototyping\Mapper\PrototypingMapper');
        $mapperHistory = $sm->get('Prototyping\Mapper\HistoryMapper');
        
        return new IndexController($options, $mapper, $mapperHistory);
    }
}
