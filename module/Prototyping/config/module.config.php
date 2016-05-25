<?php

namespace Prototyping;

return array(
    'service_manager' => array(
        'factories' => array(
            'Prototyping\Options\ModuleOptions' => 'Prototyping\Factory\ModuleOptionsFactory',
            'Prototyping\Mapper\PrototypingMapper' => 'Prototyping\Factory\PrototypingMapperFactory',
            'Prototyping\Mapper\AttachmentsMapper' => 'Prototyping\Factory\AttachmentsMapperFactory',
            'Prototyping\Mapper\HistoryMapper' => 'Prototyping\Factory\HistoryMapperFactory',
        ),
    ),
    'controllers' => array(
        'factories' => array(
            'Prototyping\Controller\Index' => 'Prototyping\Factory\Controller\IndexControllerFactory',
            'Prototyping\Controller\Attachments' => 'Prototyping\Factory\Controller\AttachmentsControllerFactory',
            'Prototyping\Controller\History' => 'Prototyping\Factory\Controller\HistoryControllerFactory',
        ),
    ),
    'router' => array(
        'routes' => array(
            'prototyping' => array(
                'type' => 'Literal',
                'priority' => 1000,
                'options' => array(
                    'route' => '/prototyping',
                    'defaults' => array(
                        'controller' => 'Prototyping\Controller\Index',
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
                                'controller' => 'Prototyping\Controller\Index',
                                'action' => 'list',
                            ),
                        ),
                    ),
                    'update' => array(
                        'type' => 'segment',
                        'options' => array(
                            'route' => '/update[/:action][/:id][/page/:page][/order_by/:order_by][/:order]',
                            'constraints' => array(
                                'action' => '(?!\bpage\b)(?!\border_by\b)(?!\bsearch_by\b)[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => '[0-9]+',
                                'page' => '[0-9]+',
                                'order_by' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'order' => 'ASC|DESC',
                            ),
                            'defaults' => array(
                                'controller' => 'Prototyping\Controller\Index',
                                'action' => 'update',
                            ),
                        ),
                    ),   
                     
                
                      
                    'search' => array(
                        'type' => 'Literal',
                        'options' => array(
                            'route' => '/search',
                            'defaults' => array(
                                'controller' => 'Prototyping\Controller\Index',
                                'action' => 'search',
                            ),
                        ),
                    ),
                    'create' => array(
                        'type' => 'Literal',
                        'options' => array(
                            'route' => '/create',
                            'defaults' => array(
                                'controller' => 'Prototyping\Controller\Index',
                                'action' => 'create',
                            ),
                        ),
                    ),
                    'edit' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/edit/:prototypingId',
                            'defaults' => array(
                                'controller' => 'Prototyping\Controller\Index',
                                'action' => 'edit',
                                'prototypingId' => 0
                            ),
                        ),
                    ),
                    'remove' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/remove/:prototypingId',
                            'defaults' => array(
                                'controller' => 'Prototyping\Controller\Index',
                                'action' => 'remove',
                                'prototypingId' => 0
                            ),
                        ),
                    ),
                    'show' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/show/:prototypingId/:historyType',
                            'defaults' => array(
                                'controller' => 'Prototyping\Controller\Index',
                                'action' => 'show',
                                'prototypingId' => 0,
                                'historyType' => 0,
                            ),
                        ),
                    ),
                    'print' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/print/:prototypingId',
                            'defaults' => array(
                                'controller' => 'Prototyping\Controller\Index',
                                'action' => 'print',
                                'prototypingId' => 0
                            ),
                        ),
                    ),                    
                    //attachment
                    'attachments' => array(
                        'type' => 'Literal',
                        'priority' => 1000,
                        'options' => array(
                            'route' => '/attachments',
                            'defaults' => array(
                                'controller' => 'Prototyping\Controller\Attachments',
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
                                        'controller' => 'Prototyping\Controller\Attachments',
                                        'action' => 'list',
                                    ),
                                ),
                            ),
                            'search' => array(
                                'type' => 'Literal',
                                'options' => array(
                                    'route' => '/search',
                                    'defaults' => array(
                                        'controller' => 'Prototyping\Controller\Attachments',
                                        'action' => 'search',
                                    ),
                                ),
                            ),
                            'add' => array(
                                'type' => 'Segment',
                                'options' => array(
                                    'route' => '/add/:prototyping_id',
                                    'constraints' => array(
                                        'prototyping_id' => '[0-9]+'
                                    ),
                                    'defaults' => array(
                                        'controller' => 'Prototyping\Controller\Attachments',
                                        'action' => 'add',
                                        'prototyping_id' => 0,
                                        'type' => 0,
                                    ),
                                ),
                            ),
                            'remove' => array(
                                'type' => 'Segment',
                                'options' => array(
                                    'route' => '/remove/:attachmentId',
                                    'defaults' => array(
                                        'controller' => 'Prototyping\Controller\Attachments',
                                        'action' => 'remove',
                                        'attachmentId' => 0
                                    ),
                                ),
                            ),
                        ),
                    ), // end attachment     
                    
                    //history
                    'history' => array(
                        'type' => 'Literal',
                        'priority' => 1000,
                        'options' => array(
                            'route' => '/history',
                            'defaults' => array(
                                'controller' => 'Prototyping\Controller\History',
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
                                        'controller' => 'Prototyping\Controller\History',
                                        'action' => 'index',
                                    ),
                                ),
                            ),
                            'edit' => array(
                                'type' => 'Segment',
                                'options' => array(
                                    'route' => '/edit/:historyId',
                                    'defaults' => array(
                                        'controller' => 'Prototyping\Controller\History',
                                        'action' => 'edit',
                                        'historyId' => 0
                                    ),
                                ),
                            ),
                            'remove' => array(
                                'type' => 'Segment',
                                'options' => array(
                                    'route' => '/remove/:historyId',
                                    'defaults' => array(
                                        'controller' => 'Prototyping\Controller\History',
                                        'action' => 'remove',
                                        'historyId' => 0
                                    ),
                                ),
                            ),                         
                        ),
                    ), // end history      
                                          
                    
                ),
            ),
        ),
    ),
    'doctrine' => array(
        'driver' => array(
            'application_entities' => array(
                'paths' => array(
                    __DIR__ . '/../../Prototyping/src/Prototyping/Entity')
            ),
            'orm_default' => array(
                'drivers' => array(
                    'Prototyping\Entity' => 'application_entities'
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
    'prototyping_opt' => [
        'attachmentPath' => '/data/attachments/prototyping/',        
    ],
    //Navigation menu/breadcrumb
    'navigation' => array(
        'leftnav' => array(
            'prototyping' => array(
                'label' => 'Ricerca & Test',
                'route' => 'prototyping',
                'icon' => 'fa fa-flask fa-fw',
                'pages' => array(
                    'list' => array(
                        'label' => 'Elenco',
                        'route' => 'prototyping/list',
                    ),   
                    'add' => array(
                        'label' => 'Richiedi',
                        'route' => 'prototyping/create',
                    ),                                         
                    'edit' => array(
                        'label' => 'Modifica',
                        'route' => 'prototyping/edit',
                        'onlybread' => true,
                    ),
                    'pritn' => array(
                        'label' => 'Stampa',
                        'route' => 'prototyping/print',
                        'onlybread' => true,
                    ),                    
                    'show' => array(
                        'label' => 'Mostra Prova',
                        'route' => 'prototyping/show',
                        'onlybread' => true,
                    ),
                    'userhistory' => array(
                        'label' => 'Storico computer di un utente',
                        'route' => 'computer/userhistory',
                        'onlybread' => true,
                    ),
                    //attachment
                    'attachmentlist' => array(
                        'label' => 'Elenco Allegati',
                        'route' => 'prototyping/attachments/list',
                        'onlybread' => false,
                        'pages' => array(                        
                            'attachmentadd' => array(
                                'label' => 'Aggiungi allegati',
                                'route' => 'prototyping/attachments/add',
                                'onlybread' => true,
                            ),
                        ),
                    ),
               
                ),
            ),
        ),
    ),
);
