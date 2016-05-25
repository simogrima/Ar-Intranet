<?php

namespace Proto;

return array(
    'service_manager' => array(
        'factories' => array(
            'Proto\Options\ModuleOptions' => 'Proto\Factory\ModuleOptionsFactory',
            'Proto\Mapper\ProtoMapper' => 'Proto\Factory\ProtoMapperFactory',
            'Proto\Mapper\AttachmentsMapper' => 'Proto\Factory\AttachmentsMapperFactory',
            'Proto\Mapper\HistoryMapper' => 'Proto\Factory\HistoryMapperFactory',
            'Proto\Mapper\SuppliesMapper' => 'Proto\Factory\SuppliesMapperFactory',
        ),
    ),
    'controllers' => array(
        'factories' => array(
            'Proto\Controller\Index' => 'Proto\Factory\Controller\IndexControllerFactory',
            'Proto\Controller\Attachments' => 'Proto\Factory\Controller\AttachmentsControllerFactory',
            'Proto\Controller\History' => 'Proto\Factory\Controller\HistoryControllerFactory',
            'Proto\Controller\Supplies' => 'Proto\Factory\Controller\SuppliesControllerFactory',
        ),
    ),
    'router' => array(
        'routes' => array(
            'proto' => array(
                'type' => 'Literal',
                'priority' => 1000,
                'options' => array(
                    'route' => '/proto',
                    'defaults' => array(
                        'controller' => 'Proto\Controller\Index',
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
                                'controller' => 'Proto\Controller\Index',
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
                                'controller' => 'Proto\Controller\Index',
                                'action' => 'update',
                            ),
                        ),
                    ),   
                     
                
                      
                    'search' => array(
                        'type' => 'Literal',
                        'options' => array(
                            'route' => '/search',
                            'defaults' => array(
                                'controller' => 'Proto\Controller\Index',
                                'action' => 'search',
                            ),
                        ),
                    ),
                    'create' => array(
                        'type' => 'Literal',
                        'options' => array(
                            'route' => '/create',
                            'defaults' => array(
                                'controller' => 'Proto\Controller\Index',
                                'action' => 'create',
                            ),
                        ),
                    ),
                    'edit' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/edit/:protoId',
                            'defaults' => array(
                                'controller' => 'Proto\Controller\Index',
                                'action' => 'edit',
                                'protoId' => 0
                            ),
                        ),
                    ),
                    'remove' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/remove/:protoId',
                            'defaults' => array(
                                'controller' => 'Proto\Controller\Index',
                                'action' => 'remove',
                                'protoId' => 0
                            ),
                        ),
                    ),
                    'show' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/show/:protoId/:historyType',
                            'defaults' => array(
                                'controller' => 'Proto\Controller\Index',
                                'action' => 'show',
                                'protoId' => 0,
                                'historyType' => 0,
                            ),
                        ),
                    ),
                    'print' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/print/:protoId',
                            'defaults' => array(
                                'controller' => 'Proto\Controller\Index',
                                'action' => 'print',
                                'protoId' => 0
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
                                'controller' => 'Proto\Controller\Attachments',
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
                                        'controller' => 'Proto\Controller\Attachments',
                                        'action' => 'list',
                                    ),
                                ),
                            ),
                            'search' => array(
                                'type' => 'Literal',
                                'options' => array(
                                    'route' => '/search',
                                    'defaults' => array(
                                        'controller' => 'Proto\Controller\Attachments',
                                        'action' => 'search',
                                    ),
                                ),
                            ),
                            'add' => array(
                                'type' => 'Segment',
                                'options' => array(
                                    'route' => '/add/:entity_id/:type',
                                    'constraints' => array(
                                        'entity_id' => '[0-9]+',
                                        'type' => '[a-zA-Z][a-zA-Z0-9_\/-]*'
                                    ),
                                    'defaults' => array(
                                        'controller' => 'Proto\Controller\Attachments',
                                        'action' => 'add',
                                        'entity_id' => 0,
                                        'type' => 0,
                                    ),
                                ),
                            ),
                            'remove' => array(
                                'type' => 'Segment',
                                'options' => array(
                                    'route' => '/remove/:attachmentId',
                                    'defaults' => array(
                                        'controller' => 'Proto\Controller\Attachments',
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
                                'controller' => 'Proto\Controller\History',
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
                                        'controller' => 'Proto\Controller\History',
                                        'action' => 'index',
                                    ),
                                ),
                            ),
                            'edit' => array(
                                'type' => 'Segment',
                                'options' => array(
                                    'route' => '/edit/:historyId',
                                    'defaults' => array(
                                        'controller' => 'Proto\Controller\History',
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
                                        'controller' => 'Proto\Controller\History',
                                        'action' => 'remove',
                                        'historyId' => 0
                                    ),
                                ),
                            ),                         
                        ),
                    ), // end history      
                    
                    //supplies
                    'supplies' => array(
                        'type' => 'Literal',
                        'priority' => 1000,
                        'options' => array(
                            'route' => '/supplies',
                            'defaults' => array(
                                'controller' => 'Proto\Controller\Supplies',
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
                                        'controller' => 'Proto\Controller\Supplies',
                                        'action' => 'list',
                                    ),
                                ),
                            ),
                            'search' => array(
                                'type' => 'Literal',
                                'options' => array(
                                    'route' => '/search',
                                    'defaults' => array(
                                        'controller' => 'Proto\Controller\Supplies',
                                        'action' => 'search',
                                    ),
                                ),
                            ),
                            'add' => array(
                                'type' => 'Segment',
                                'options' => array(
                                    'route' => '/add/:proto_id',
                                    'constraints' => array(
                                        'proto_id' => '[0-9]+',
                                        'type' => '[a-zA-Z][a-zA-Z0-9_\/-]*'
                                    ),
                                    'defaults' => array(
                                        'controller' => 'Proto\Controller\Supplies',
                                        'action' => 'add',
                                        'proto_id' => 0,
                                    ),
                                ),
                            ),                            
                            'edit' => array(
                                'type' => 'Segment',
                                'options' => array(
                                    'route' => '/edit/:supplyId',
                                    'defaults' => array(
                                        'controller' => 'Proto\Controller\Supplies',
                                        'action' => 'edit',
                                        'supplyId' => 0
                                    ),
                                ),
                            ),
                            'attachments' => array(
                                'type' => 'Segment',
                                'options' => array(
                                    'route' => '/attachments/:supplyId',
                                    'defaults' => array(
                                        'controller' => 'Proto\Controller\Supplies',
                                        'action' => 'attachments',
                                        'supplyId' => 0
                                    ),
                                ),
                            ),                            
                            'remove' => array(
                                'type' => 'Segment',
                                'options' => array(
                                    'route' => '/remove/:supplyId',
                                    'defaults' => array(
                                        'controller' => 'Proto\Controller\Supplies',
                                        'action' => 'remove',
                                        'supplyId' => 0
                                    ),
                                ),
                            ),                         
                        ),
                    ), // end supplies                       
                                          
                    
                ),
            ),
        ),
    ),
    'doctrine' => array(
        'driver' => array(
            'application_entities' => array(
                'paths' => array(
                    __DIR__ . '/../../Proto/src/Proto/Entity')
            ),
            'orm_default' => array(
                'drivers' => array(
                    'Proto\Entity' => 'application_entities'
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
    'proto_opt' => [
        'attachmentPath' => '/data/attachments/proto/',  
        'emailToNewRequest' => [
            //'grimani@ariete.net',
            //'simogrima@gmail.com',
            'veronica.salvadori@ariete.net',
            'filippo.ringressi@ariete.net',
        ],        
    ],
    //Navigation menu/breadcrumb
    'navigation' => array(
        'leftnav' => array(
            'proto' => array(
                'label' => 'Prototipi',
                'route' => 'proto',
                'icon' => 'fa fa-lightbulb-o fa-fw',
                'pages' => array(
                    'list' => array(
                        'label' => 'Elenco',
                        'route' => 'proto/list',
                    ),   
                    'add' => array(
                        'label' => 'Richiedi',
                        'route' => 'proto/create',
                    ),                                         
                    'edit' => array(
                        'label' => 'Modifica',
                        'route' => 'proto/edit',
                        'onlybread' => true,
                    ),
                    'pritn' => array(
                        'label' => 'Stampa',
                        'route' => 'proto/print',
                        'onlybread' => true,
                    ),                    
                    'show' => array(
                        'label' => 'Mostra Richiesta',
                        'route' => 'proto/show',
                        'onlybread' => true,
                    ),
                    'userhistory' => array(
                        'label' => 'Storico computer di un utente',
                        'route' => 'computer/userhistory',
                        'onlybread' => true,
                    ),
                    /**attachment
                    'attachmentlist' => array(
                        'label' => 'Elenco Allegati',
                        'route' => 'proto/attachments/list',
                        'onlybread' => false,
                        'pages' => array(                        
                            'attachmentadd' => array(
                                'label' => 'Aggiungi allegati',
                                'route' => 'proto/attachments/add',
                                'onlybread' => true,
                            ),
                        ),
                    ),
                     * 
                     */
                    //supplies
                    'supplieslist' => array(
                        'label' => 'Elenco Forniture',
                        'route' => 'proto/supplies/list',
                        'onlybread' => false,
                        'pages' => array(                        
                            'supplyadd' => array(
                                'label' => 'Aggiungi fornitura',
                                'route' => 'proto/supplies/add',
                                'onlybread' => true,
                            ),
                        ),
                    ),                    
               
                ),
            ),
        ),
    ),
);
