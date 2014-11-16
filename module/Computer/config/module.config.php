<?php

namespace Computer;

return array(
    'service_manager' => array(
        'factories' => array(
            'Computer\Options\ModuleOptions' => 'Computer\Factory\ModuleOptionsFactory',
            'Computer\Mapper\ComputerMapper' => 'Computer\Factory\ComputerMapperFactory',
            'Computer\Mapper\CategoryMapper' => 'Computer\Factory\CategoryMapperFactory',
        ),
    ),
    'controllers' => array(
        'factories' => array(
            'Computer\Controller\Index' => 'Computer\Factory\Controller\IndexControllerFactory',
            'Computer\Controller\Category' => 'Computer\Factory\Controller\CategoryControllerFactory',
        ),
    ),
    'router' => array(
        'routes' => array(
            'computer' => array(
                'type' => 'Literal',
                'priority' => 1000,
                'options' => array(
                    'route' => '/computer',
                    'defaults' => array(
                        'controller' => 'Computer\Controller\Index',
                        'action' => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'list' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/list[/:page]',
                            'constraints' => array(
                                'page' => '[0-9]+',
                            ),
                            'defaults' => array(
                                'controller' => 'Computer\Controller\Index',
                                'action' => 'list',
                            ),
                        ),
                    ),
                    'create' => array(
                        'type' => 'Literal',
                        'options' => array(
                            'route' => '/create',
                            'defaults' => array(
                                'controller' => 'Computer\Controller\Index',
                                'action' => 'create',
                            ),
                        ),
                    ),
                    'edit' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/edit/:computerId',
                            'defaults' => array(
                                'controller' => 'Computer\Controller\Index',
                                'action' => 'edit',
                                'computerId' => 0
                            ),
                        ),
                    ),
                    'remove' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/remove/:computerId',
                            'defaults' => array(
                                'controller' => 'Computer\Controller\Index',
                                'action' => 'remove',
                                'computerId' => 0
                            ),
                        ),
                    ),
                    'category' => array(
                        'type' => 'Literal',
                        'priority' => 1000,
                        'options' => array(
                            'route' => '/category',
                            'defaults' => array(
                                'controller' => 'Computer\Controller\Category',
                                'action' => 'index',
                            ),
                        ),
                        'may_terminate' => true,
                        'child_routes' => array(
                            'create' => array(
                                'type' => 'Literal',
                                'options' => array(
                                    'route' => '/create',
                                    'defaults' => array(
                                        'controller' => 'Computer\Controller\Category',
                                        'action' => 'create',
                                    ),
                                ),
                            ),
                            'edit' => array(
                                'type' => 'Segment',
                                'options' => array(
                                    'route' => '/edit/:computerId',
                                    'defaults' => array(
                                        'controller' => 'Computer\Controller\Category',
                                        'action' => 'edit',
                                        'computerId' => 0
                                    ),
                                ),
                            ),
                            'remove' => array(
                                'type' => 'Segment',
                                'options' => array(
                                    'route' => '/remove/:computerId',
                                    'defaults' => array(
                                        'controller' => 'Computer\Controller\Category',
                                        'action' => 'remove',
                                        'computerId' => 0
                                    ),
                                ),
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
                    __DIR__ . '/../../Computer/src/Computer/Entity')
            ),
            'orm_default' => array(
                'drivers' => array(
                    'Computer\Entity' => 'application_entities'
                )
            )
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            __NAMESPACE__ => __DIR__ . '/../view',
        ),
    ),
    //My module options
    'computer_opt' => [],
);
