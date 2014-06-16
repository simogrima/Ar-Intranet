<?php

namespace Admin;

return array(
    'controllers' => array(
        'invokables' => array(
            __NAMESPACE__ . '\Controller\FooController' => __NAMESPACE__ . '\Controller\FooController',
            __NAMESPACE__ . '\Controller\IndexController' => __NAMESPACE__ . '\Controller\IndexController'
        ),
        'aliases' => array(
            'adminIndex' => __NAMESPACE__ . '\Controller\IndexController',
            'adminFoo' => __NAMESPACE__ . '\Controller\FooController',
        ),
    ),  
    'router' => array(
        'routes' => array(
            'zfcadmin' => array(
                'child_routes' => array(
                    'foo' => array(
                        'type' => 'literal',
                        'options' => array(
                            'route' => '/foo',
                            'defaults' => array(
                                'controller' => 'adminFoo',
                                'action' => 'index',
                            ),
                        ),
                    ),
                ),
                'options' => array(
                    'defaults' => array(
                        'controller' => 'adminIndex',
                        'action' => 'dashboard',
                    ),
                ),
            ),
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            __NAMESPACE__ => __DIR__ . '/../view',
        ),
        'template_map' => array(
            'paginator-slide' => __DIR__ . '/../view/layout/slidePaginator.phtml',
        ),         
    ),
    'navigation' => array(
        'myadmin' => array(
            'foo' => array(
                'label' => 'Foo',
                'route' => 'zfcadmin/foo',
                'icon' => 'glyphicon glyphicon-tower'
            ),
            'zfcuseradmin' => array(
                'label' => 'Users',
                'route' => 'zfcadmin/zfcuseradmin/list',
                'icon' => 'glyphicon glyphicon-user',
                'pages' => array(
                    'list' => array(
                        'label' => 'Elenco',
                        'route' => 'zfcadmin/zfcuseradmin/list',
                    ),                    
                    'add' => array(
                        'label' => 'New User',
                        'route' => 'zfcadmin/zfcuseradmin/create',
                    ),
                ),
            ),              
        ),
    ),    
);
