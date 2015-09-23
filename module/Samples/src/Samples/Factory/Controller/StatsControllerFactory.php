<?php


namespace Samples\Factory\Controller;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Samples\Controller\StatsController;

/**
 * Factory to create a stats controller
 */
class StatsControllerFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /* @var $serviceLocator \Zend\Mvc\Controller\ControllerManager */
        $sm   = $serviceLocator->getServiceLocator();
        $options = $sm->get('Samples\Options\ModuleOptions');
        $mapper = $sm->get('Samples\Mapper\SampleMapper');
        $mapperHistory = $sm->get('Samples\Mapper\HistoryMapper');
        
        return new StatsController($options, $mapper, $mapperHistory);
    }
}
