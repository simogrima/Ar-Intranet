<?php


namespace Proto\Factory\Controller;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Proto\Controller\IndexController;

/**
 * Factory to create a index controller
 */
class IndexControllerFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /* @var $serviceLocator \Zend\Mvc\Controller\ControllerManager */
        $sm   = $serviceLocator->getServiceLocator();
        $options = $sm->get('Proto\Options\ModuleOptions');
        $mapper = $sm->get('Proto\Mapper\ProtoMapper');
        $mapperHistory = $sm->get('Proto\Mapper\HistoryMapper');
        
        return new IndexController($options, $mapper, $mapperHistory);
    }
}
