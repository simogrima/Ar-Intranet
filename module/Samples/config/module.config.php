<?php

return array(
    'service_manager' => array(
        'factories' => array(
            'Samples\Options\ModuleOptions' => 'Samples\Factory\ModuleOptionsFactory',
            'Samples\Mapper\SampleMapper' => 'Samples\Factory\SampleMapperFactory',
        ),
    ),
    'controllers' => array(
        'factories' => array(
            'Samples\Controller\Index' => 'Samples\Factory\Controller\IndexControllerFactory',
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
                                'controller' => 'Samples\Controller\Index',
                                'action' => 'list',
                            ),
                        ),
                    ),
                    'create' => array(
                        'type' => 'Literal',
                        'options' => array(
                            'route' => '/create',
                            'defaults' => array(
                                'controller' => 'Samples\Controller\Index',
                                'action' => 'create',
                            ),
                        ),
                    ),
                    'edit' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/edit/:sampleId',
                            'defaults' => array(
                                'controller' => 'Samples\Controller\Index',
                                'action' => 'edit',
                                'sampleId' => 0
                            ),
                        ),
                    ),
                    'remove' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/remove/:sampleId',
                            'defaults' => array(
                                'controller' => 'Samples\Controller\Index',
                                'action' => 'remove',
                                'sampleId' => 0
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
    //My module options
    'sample_opt' => [],
);
