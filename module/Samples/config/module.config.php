<?php

namespace Samples;

return array(
    'service_manager' => array(
        'factories' => array(
            'Samples\Options\ModuleOptions' => 'Samples\Factory\ModuleOptionsFactory',
            'Samples\Mapper\SampleMapper' => 'Samples\Factory\SampleMapperFactory',
            'Samples\Mapper\AttachmentsMapper' => 'Samples\Factory\AttachmentsMapperFactory',
            'Samples\Mapper\HistoryMapper' => 'Samples\Factory\HistoryMapperFactory',
        ),
    ),
    'controllers' => array(
        'factories' => array(
            'Samples\Controller\Index' => 'Samples\Factory\Controller\IndexControllerFactory',
            'Samples\Controller\Attachments' => 'Samples\Factory\Controller\AttachmentsControllerFactory',
            'Samples\Controller\History' => 'Samples\Factory\Controller\HistoryControllerFactory',
            'Samples\Controller\Stats' => 'Samples\Factory\Controller\StatsControllerFactory',
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
                                'controller' => 'Samples\Controller\Index',
                                'action' => 'update',
                            ),
                        ),
                    ),   
                    'myopen' => array(
                        'type' => 'segment',
                        'options' => array(
                            'route' => '/my-open-samples[/:action][/:id][/page/:page][/order_by/:order_by][/:order]',
                            'constraints' => array(
                                'action' => '(?!\bpage\b)(?!\border_by\b)(?!\bsearch_by\b)[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => '[0-9]+',
                                'page' => '[0-9]+',
                                'order_by' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'order' => 'ASC|DESC',
                            ),
                            'defaults' => array(
                                'controller' => 'Samples\Controller\Index',
                                'action' => 'my-open-samples',
                            ),
                        ),
                    ),                       
                    'ship' => array(
                        'type' => 'segment',
                        'options' => array(
                            'route' => '/ship[/:action][/:id][/page/:page][/order_by/:order_by][/:order]',
                            'constraints' => array(
                                'action' => '(?!\bpage\b)(?!\border_by\b)(?!\bsearch_by\b)[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => '[0-9]+',
                                'page' => '[0-9]+',
                                'order_by' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'order' => 'ASC|DESC',
                            ),
                            'defaults' => array(
                                'controller' => 'Samples\Controller\Index',
                                'action' => 'ship',
                            ),
                        ),
                    ),         
                    'processing' => array(
                        'type' => 'segment',
                        'options' => array(
                            'route' => '/processing[/:action][/:id][/page/:page][/order_by/:order_by][/:order]',
                            'constraints' => array(
                                'action' => '(?!\bpage\b)(?!\border_by\b)(?!\bsearch_by\b)[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => '[0-9]+',
                                'page' => '[0-9]+',
                                'order_by' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'order' => 'ASC|DESC',
                            ),
                            'defaults' => array(
                                'controller' => 'Samples\Controller\Index',
                                'action' => 'processing',
                            ),
                        ),
                    ),                     
                    'migration' => array(
                        'type' => 'Literal',
                        'options' => array(
                            'route' => '/migration',
                            'defaults' => array(
                                'controller' => 'Samples\Controller\Index',
                                'action' => 'migration',
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
                    'show' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/show/:sampleId/:historyType',
                            'defaults' => array(
                                'controller' => 'Samples\Controller\Index',
                                'action' => 'show',
                                'sampleId' => 0,
                                'historyType' => 0,
                            ),
                        ),
                    ),
                    'print' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/print/:sampleId',
                            'defaults' => array(
                                'controller' => 'Samples\Controller\Index',
                                'action' => 'print',
                                'sampleId' => 0
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
                                'controller' => 'Samples\Controller\Attachments',
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
                                        'controller' => 'Samples\Controller\Attachments',
                                        'action' => 'list',
                                    ),
                                ),
                            ),
                            'search' => array(
                                'type' => 'Literal',
                                'options' => array(
                                    'route' => '/search',
                                    'defaults' => array(
                                        'controller' => 'Samples\Controller\Attachments',
                                        'action' => 'search',
                                    ),
                                ),
                            ),
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
                            'remove' => array(
                                'type' => 'Segment',
                                'options' => array(
                                    'route' => '/remove/:attachmentId',
                                    'defaults' => array(
                                        'controller' => 'Samples\Controller\Attachments',
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
                                'controller' => 'Samples\Controller\History',
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
                                        'controller' => 'Samples\Controller\History',
                                        'action' => 'index',
                                    ),
                                ),
                            ),
                            'edit' => array(
                                'type' => 'Segment',
                                'options' => array(
                                    'route' => '/edit/:historyId',
                                    'defaults' => array(
                                        'controller' => 'Samples\Controller\History',
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
                                        'controller' => 'Samples\Controller\History',
                                        'action' => 'remove',
                                        'historyId' => 0
                                    ),
                                ),
                            ),
                            'shipping' => array(
                                'type' => 'Segment',
                                'options' => array(
                                    'route' => '/shipping/:sampleId',
                                    'defaults' => array(
                                        'controller' => 'Samples\Controller\History',
                                        'action' => 'shipping',
                                        'sampleId' => 0
                                    ),
                                ),
                            ),                            
                        ),
                    ), // end history      
                    
                    //stats
                    'stats' => array(
                        'type' => 'Literal',
                        'priority' => 1000,
                        'options' => array(
                            'route' => '/stats',
                            'defaults' => array(
                                'controller' => 'Samples\Controller\Stats',
                                'action' => 'index',
                            ),
                        ),
                        'may_terminate' => true,
                        'child_routes' => array(
                            'stat1' => array(
                                'type' => 'Segment',
                                'options' => array(
                                    'route' => '/stat1/:year',
                                    'defaults' => array(
                                        'controller' => 'Samples\Controller\Stats',
                                        'action' => 'stat1',
                                        'historyId' => 0
                                    ),
                                ),
                            ),                          
                        ),
                    ), // end stats                        
                    
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
    'sample_opt' => [
        'attachmentPath' => '/data/attachments/',
        'emailToNewSample' => [
            //'grimani@ariete.net',
            //'simogrima@gmail.com',
            'gianni.maggini@ariete.net',
            'riccardo.biagioli@ariete.net',
            'simone.barbanti@ariete.net',
        ],
        'emailToProcessedSample' => [
            //'simogrima@gmail.com',
            'riccardo.peschi@ariete.net',
        ],    
        'emailToShippingReady' => [
            //'simogrima@gmail.com',
            //'giuseppe.turturiello@ariete.net',
        ],     
        'emailToProductRequired' => [
            'carlo.rosa@ariete.net',
            'erica.chelli@ariete.net',
            'riccardo.peschi@ariete.net',
            'matteo.bacchelli@ariete.net',
            'massimiliano.stagi@ariete.net',
            'massimo.palchetti@ariete.net',
            'giuseppe.turturiello@ariete.net',
        ],        
    ],
    //Navigation menu/breadcrumb
    'navigation' => array(
        'leftnav' => array(
            'samples' => array(
                'label' => 'Campionature',
                'route' => 'samples',
                'icon' => 'fa fa-cubes fa-fw',
                'pages' => array(
                    'dashboard' => array(
                        'label' => 'Dashboard',
                        'route' => 'samples',
                    ),
                    'add' => array(
                        'label' => 'Richiedi Campionatura',
                        'route' => 'samples/create',
                    ),
                    'list' => array(
                        'label' => 'Elenco Campionature',
                        'route' => 'samples/list',
                    ),   
                    'update' => array(
                        'label' => 'Aggiorna dati',
                        'route' => 'samples/update',
                    ),  
                    'myopen' => array(
                        'label' => 'Mie Campionature Aperte',
                        'route' => 'samples/myopen',
                        'onlybread' => true,
                    ),                      
                    'processing' => array(
                        'label' => 'Invia a magazzino',
                        'route' => 'samples/processing',
                    ),                     
                    'ship' => array(
                        'label' => 'Spedizioni',
                        'route' => 'samples/ship',
                    ),                     
                    'edit' => array(
                        'label' => 'Modifica Campionatura',
                        'route' => 'samples/edit',
                        'onlybread' => true,
                    ),
                    'show' => array(
                        'label' => 'Mostra Campionatura',
                        'route' => 'samples/show',
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
                        'route' => 'samples/attachments/list',
                        'onlybread' => false,
                        'pages' => array(                        
                            'attachmentadd' => array(
                                'label' => 'Aggiungi allegato/i',
                                'route' => 'samples/attachments/add',
                                'onlybread' => true,
                            ),
                        ),
                    ),
                    //stats
                    'stats' => array(
                        'label' => 'Statistiche',
                        'route' => 'samples/stats',
                        'onlybread' => false,
                        'pages' => array(                        
                            'processed' => array(
                                'label' => 'Campioni evasi per mese',
                                'route' => 'samples/stats/stat1',
                                'onlybread' => true,
                            ),
                        ),
                    ),                    
                ),
            ),
        ),
    ),
);
