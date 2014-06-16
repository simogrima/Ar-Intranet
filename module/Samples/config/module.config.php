<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'Samples\Controller\Index' => 'Samples\Controller\IndexController',
        ),
    ),    
    
    'router' => array(
        'routes' => array(
            'samples' => array(
                'type' => 'Literal',
                'priority' => 1000,
                'options' => array(
                    'route' => '/samples',
                    'defaults' => array(
                        'controller' => 'Samples\Controller\Index',
                        'action'     => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'login' => array(
                        'type' => 'Literal',
                        'options' => array(
                            'route' => '/create',
                            'defaults' => array(
                                'controller' => 'Samples\Controller\Index',
                                'action'     => 'create',
                            ),
                        ),
                    ),


                ),
            ),
        ),
    ),       
    
    'doctrine' => array(
        'driver' => array(
            'application_entities' => array(
                'paths' => array(
                    __DIR__ . '/../../Samples/src/Samples/Entity')
            ),
            'orm_default' => array(
                'drivers' => array(
                    'Samples\Entity' => 'application_entities'
                )
            )
        ),
    ),      
    
    'view_manager' => array(
        'template_path_stack' => array(
            __NAMESPACE__ => __DIR__ . '/../view',
        ),
    ),    
);