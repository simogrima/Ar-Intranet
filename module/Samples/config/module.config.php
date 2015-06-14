<?php
namespace Samples;

return array(
    'service_manager' => array(
        'factories' => array(
            'Samples\Options\ModuleOptions' => 'Samples\Factory\ModuleOptionsFactory',
            'Samples\Mapper\SampleMapper' => 'Samples\Factory\SampleMapperFactory',
            'Samples\Mapper\AttachmentsMapper' => 'Samples\Factory\AttachmentsMapperFactory',
        ),
    ),
    'controllers' => array(
        'factories' => array(
            'Samples\Controller\Index' => 'Samples\Factory\Controller\IndexControllerFactory',
            'Samples\Controller\Attachments' => 'Samples\Factory\Controller\AttachmentsControllerFactory',
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
                        'type' => 'segment',
                        'options' => array(
                            'route' => '/list[/:action][/:id][/page/:page][/order_by/:order_by][/:order][/search_by/:search_by]',
                            'constraints' => array(
                                'action' => '(?!\bpage\b)(?!\border_by\b)(?!\bsearch_by\b)[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => '[0-9]+',
                                'page' => '[0-9]+',
                                'order_by' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'order' => 'ASC|DESC',
                            ),
                            'defaults' => array(
                                'controller' => 'Samples\Controller\Index',
                                'action' => 'list',
                            ),
                        ),
                    ),                    
                    'search' => array(
                        'type' => 'Literal',
                        'options' => array(
                            'route' => '/search',
                            'defaults' => array(
                                'controller' => 'Samples\Controller\Index',
                                'action' => 'search',
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
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    'attachments' => array(
                        'type' => 'Literal',
                        'priority' => 1000,
                        'options' => array(
                            'route' => '/attachments',
                            'defaults' => array(
                                'controller' => 'Samples\Controller\Attachments',
                                'action' => 'index',
                            ),
                        ),
                        'may_terminate' => true,
                        'child_routes' => array(
                            'add' => array(
                                'type' => 'Segment',
                                'options' => array(
                                    'route' => '/add/:sample_id/:type',
                                    'constraints' => array(
                                        'sample_id' => '[0-9]+',
                                        'type' => '[a-zA-Z][a-zA-Z0-9_\/-]*'
                                    ),                                    
                                    'defaults' => array(
                                        'controller' => 'Samples\Controller\Attachments',
                                        'action' => 'add',
                                        'sample_id' => 0,
                                        'type' => 0,
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
                    ), // end brand                    
                    
                    
                    
                    

                    
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
    
    //Navigation menu/breadcrumb
    'navigation' => array(
        'leftnav' => array(
            'samples' => array(
                'label' => 'Campioni',
                'route' => 'samples',
                'icon' => 'fa fa-cubes fa-fw',
                'pages' => array(
                    'dashboard' => array(
                        'label' => 'Dashboard',
                        'route' => 'samples',
                    ),
                    'list' => array(
                        'label' => 'Elenco',
                        'route' => 'samples/list',
                    ),
                    'add' => array(
                        'label' => 'Nuova Campionatura',
                        'route' => 'samples/create',
                    ),
                    'edit' => array(
                        'label' => 'Modifica Campionatura',
                        'route' => 'samples/edit',
                        'onlybread' => true,
                    ),
                    'show' => array(
                        'label' => 'Mostra Campionatura',
                        'route' => 'computer/show',
                        'onlybread' => true,
                    ),
                    'userhistory' => array(
                        'label' => 'Storico computer di un utente',
                        'route' => 'computer/userhistory',
                        'onlybread' => true,
                    ),                  
                    //Category
                    'catlist' => array(
                        'label' => 'Categorie computer',
                        'route' => 'computer/category',
                        'onlybread' => true,
                        'pages' => array(
                            'catadd' => array(
                                'label' => 'Nuova categoria computer',
                                'route' => 'computer/category/create',
                                'onlybread' => true,
                            ),
                            'catedit' => array(
                                'label' => 'Modifica categoria computer',
                                'route' => 'computer/category/edit',
                                'onlybread' => true,
                            ),
                        ),
                    ),
                    //brand
                    'brandlist' => array(
                        'label' => 'Brands computer',
                        'route' => 'computer/brand',
                        'onlybread' => true,
                        'pages' => array(
                            'branadd' => array(
                                'label' => 'Nuovo brand computer',
                                'route' => 'computer/brand/create',
                                'onlybread' => true,
                            ),
                            'brandedit' => array(
                                'label' => 'Modifica brand computer',
                                'route' => 'computer/brand/edit',
                                'onlybread' => true,
                            ),
                        ),
                    ),
                    //processor
                    'processorlist' => array(
                        'label' => 'Processore computer',
                        'route' => 'computer/processor',
                        'onlybread' => true,
                        'pages' => array(
                            'processoradd' => array(
                                'label' => 'Nuovo processore computer',
                                'route' => 'computer/processor/create',
                                'onlybread' => true,
                            ),
                            'processoredit' => array(
                                'label' => 'Modifica processore computer',
                                'route' => 'computer/processor/edit',
                                'onlybread' => true,
                            ),
                        ),
                    ),
                    //history
                    'historylist' => array(
                        'label' => 'Storico computers',
                        'route' => 'computer/history',
                        'pages' => array(
                            'historyedit' => array(
                                'label' => 'Modifica storico computer',
                                'route' => 'computer/history/edit',
                                'onlybread' => true,
                            ),                        
                        ),
                    ),
                    'userhistory' => array(
                        'label' => 'Storico computers utente',
                        'route' => 'computer/userhistory',
                        'onlybread' => false,
                    ),                       
                    'settings' => array(
                        'label' => 'Impostazioni',
                        'route' => 'computer/settings',
                    ),                      
                ),
            ),
        ),
    ),    
);
