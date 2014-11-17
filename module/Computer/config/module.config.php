<?php

namespace Computer;

return array(
    'service_manager' => array(
        'factories' => array(
            'Computer\Options\ModuleOptions' => 'Computer\Factory\ModuleOptionsFactory',
            'Computer\Mapper\ComputerMapper' => 'Computer\Factory\ComputerMapperFactory',
            'Computer\Mapper\CategoryMapper' => 'Computer\Factory\CategoryMapperFactory',
            'Computer\Mapper\BrandMapper' => 'Computer\Factory\BrandMapperFactory',
            'Computer\Mapper\ProcessorMapper' => 'Computer\Factory\ProcessorMapperFactory',
        ),
    ),
    'controllers' => array(
        'factories' => array(
            'Computer\Controller\Index' => 'Computer\Factory\Controller\IndexControllerFactory',
            'Computer\Controller\Category' => 'Computer\Factory\Controller\CategoryControllerFactory',
            'Computer\Controller\Brand' => 'Computer\Factory\Controller\BrandControllerFactory',
            'Computer\Controller\Processor' => 'Computer\Factory\Controller\ProcessorControllerFactory',
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
                    'settings' => array(
                        'type' => 'Literal',
                        'options' => array(
                            'route' => '/settings',
                            'defaults' => array(
                                'controller' => 'Computer\Controller\Index',
                                'action' => 'settings',
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
                                    'route' => '/edit/:categoryId',
                                    'defaults' => array(
                                        'controller' => 'Computer\Controller\Category',
                                        'action' => 'edit',
                                        'categoryId' => 0
                                    ),
                                ),
                            ),
                            'remove' => array(
                                'type' => 'Segment',
                                'options' => array(
                                    'route' => '/remove/:categoryId',
                                    'defaults' => array(
                                        'controller' => 'Computer\Controller\Category',
                                        'action' => 'remove',
                                        'categoryId' => 0
                                    ),
                                ),
                            ),
                        ),
                    ),
                    'brand' => array(
                        'type' => 'Literal',
                        'priority' => 1000,
                        'options' => array(
                            'route' => '/brand',
                            'defaults' => array(
                                'controller' => 'Computer\Controller\Brand',
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
                                        'controller' => 'Computer\Controller\Brand',
                                        'action' => 'create',
                                    ),
                                ),
                            ),
                            'edit' => array(
                                'type' => 'Segment',
                                'options' => array(
                                    'route' => '/edit/:brandId',
                                    'defaults' => array(
                                        'controller' => 'Computer\Controller\Brand',
                                        'action' => 'edit',
                                        'brandId' => 0
                                    ),
                                ),
                            ),
                            'remove' => array(
                                'type' => 'Segment',
                                'options' => array(
                                    'route' => '/remove/:brandId',
                                    'defaults' => array(
                                        'controller' => 'Computer\Controller\Brand',
                                        'action' => 'remove',
                                        'brandId' => 0
                                    ),
                                ),
                            ),
                        ),
                    ),// end brand
                    'processor' => array(
                        'type' => 'Literal',
                        'priority' => 1000,
                        'options' => array(
                            'route' => '/processor',
                            'defaults' => array(
                                'controller' => 'Computer\Controller\Processor',
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
                                        'controller' => 'Computer\Controller\Processor',
                                        'action' => 'create',
                                    ),
                                ),
                            ),
                            'edit' => array(
                                'type' => 'Segment',
                                'options' => array(
                                    'route' => '/edit/:processorId',
                                    'defaults' => array(
                                        'controller' => 'Computer\Controller\Processor',
                                        'action' => 'edit',
                                        'processorId' => 0
                                    ),
                                ),
                            ),
                            'remove' => array(
                                'type' => 'Segment',
                                'options' => array(
                                    'route' => '/remove/:processorId',
                                    'defaults' => array(
                                        'controller' => 'Computer\Controller\Processor',
                                        'action' => 'remove',
                                        'processorId' => 0
                                    ),
                                ),
                            ),
                        ),
                    ),// end processor                    
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
    
    'navigation' => array(
        'leftnav' => array(
            'computer' => array(
                'label' => 'Computers',
                'route' => 'computer',
                'icon' => 'fa fa-laptop fa-fw',
                'pages' => array(
                    'dashboard' => array(
                        'label' => 'Dashboard',
                        'route' => 'computer',
                    ),                      
                    'list' => array(
                        'label' => 'Elenco',
                        'route' => 'computer/list',
                    ),                    
                    'add' => array(
                        'label' => 'New User',
                        'route' => 'computer/create',
                    ),
                ),
            ),              
        ),
    ),      
        
);
