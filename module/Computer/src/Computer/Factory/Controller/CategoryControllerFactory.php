<?php


namespace Computer\Factory\Controller;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Computer\Controller\CategoryController;

/**
 * Factory to create a category controller
 */
class CategoryControllerFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /* @var $serviceLocator \Zend\Mvc\Controller\ControllerManager */
        $sm   = $serviceLocator->getServiceLocator();
        $options = $sm->get('Computer\Options\ModuleOptions');
        $mapper = $sm->get('Computer\Mapper\CategoryMapper');
        
        return new CategoryController($options, $mapper);
    }
}
