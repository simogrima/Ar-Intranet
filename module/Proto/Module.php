<?php

namespace Proto;

use Zend\Mvc\MvcEvent,
    Zend\Mvc\ModuleRouteListener;

class Module
{

    //Disable layout on ajax request
    public function onBootstrap(MvcEvent $e)
    {
        $eventManager = $e->getApplication()->getEventManager();

        // The next two lines are from the Zend Skeleton Application found on git
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);

        // Hybrid view for ajax calls (disable layout for xmlHttpRequests)
        $eventManager->getSharedManager()->attach('Zend\Mvc\Controller\AbstractController', MvcEvent::EVENT_DISPATCH, function(MvcEvent $event) {

            /**
             * @var Request $request
             */
            $request = $event->getRequest();
            $viewModel = $event->getResult();

            if ($request->isXmlHttpRequest()) {
                $viewModel->setTerminal(true);
            }

            return $viewModel;
        }, -95);
    }    
    
    
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }
}
