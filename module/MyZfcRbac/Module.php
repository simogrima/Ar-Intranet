<?php
namespace MyZfcRbac;

use Zend\EventManager\EventInterface as Event;

class Module
{
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
    
    public function onBootstrap(Event $e)
    {
        $t = $e->getTarget();

        $t->getEventManager()->attach(
                $t->getServiceManager()->get('MyZfcRbac\View\Strategy\DynamicStrategy')
        );
    }     
    
    public function getControllerConfig()
    {
        return include __DIR__ . '/config/controllers.config.php';
    }     
}
