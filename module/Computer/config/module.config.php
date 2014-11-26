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
            'Computer\Mapper\HistoryMapper' => 'Computer\Factory\HistoryMapperFactory',
        ),
    ),
    'controllers' => array(
        'factories' => array(
            'Computer\Controller\Index' => 'Computer\Factory\Controller\IndexControllerFactory',
            'Computer\Controller\Category' => 'Computer\Factory\Controller\CategoryControllerFactory',
            'Computer\Controller\Brand' => 'Computer\Factory\Controller\BrandControllerFactory',
            'Computer\Controller\Processor' => 'Computer\Factory\Controller\ProcessorControllerFactory',
            'Computer\Controller\History' => 'Computer\Factory\Controller\HistoryControllerFactory',
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
                                'controller' => 'Computer\Controller\Index',
                                'action' => 'list',
                            ),
                        ),
                    ),
                    'search' => array(
                        'type' => 'Literal',
                        'options' => array(
                            'route' => '/search',
                            'defaults' => array(
                                'controller' => 'Computer\Controller\Index',
                                'action' => 'search',
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
                    'clearhistory' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/clear-history/:computerId',
                            'defaults' => array(
                                'controller' => 'Computer\Controller\Index',
                                'action' => 'clearHistory',
                                'computerId' => 0,
                            ),
                        ),
                    ),
                    'show' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/show/:computerId/:historyType',
                            'defaults' => array(
                                'controller' => 'Computer\Controller\Index',
                                'action' => 'show',
                                'computerId' => 0,
                                'historyType' => 0,
                            ),
                        ),
                    ),
                    'userhistory' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/user-history/:userId',
                            'defaults' => array(
                                'controller' => 'Computer\Controller\Index',
                                'action' => 'userHistory',
                                'userId' => 0,
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
                    ), // end brand
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
                    ), // end processor
                    'history' => array(
                        'type' => 'Literal',
                        'priority' => 1000,
                        'options' => array(
                            'route' => '/history',
                            'defaults' => array(
                                'controller' => 'Computer\Controller\History',
                                'action' => 'index',
                            ),
                        ),
                        'may_terminate' => true,
                        'child_routes' => array(
                            'edit' => array(
                                'type' => 'Segment',
                                'options' => array(
                                    'route' => '/edit/:historyId',
                                    'defaults' => array(
                                        'controller' => 'Computer\Controller\History',
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
                                        'controller' => 'Computer\Controller\History',
                                        'action' => 'remove',
                                        'historyId' => 0
                                    ),
                                ),
                            ),
                            'search' => array(
                                'type' => 'Literal',
                                'options' => array(
                                    'route' => '/search',
                                    'defaults' => array(
                                        'controller' => 'Computer\Controller\History',
                                        'action' => 'search',
                                    ),
                                ),
                            ),
                        ),
                    ), // end processor                      
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
    'computer_opt' => [
        'scortaId' => 2,
        'scortaUserId' => 2,
    ],
    //Navigation menu/breadcrumb
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
                    'settings' => array(
                        'label' => 'Impostazioni',
                        'route' => 'computer/settings',
                    ),
                    'list' => array(
                        'label' => 'Elenco',
                        'route' => 'computer/list',
                    ),
                    'add' => array(
                        'label' => 'Nuovo Computer',
                        'route' => 'computer/create',
                    ),
                    'edit' => array(
                        'label' => 'Modifica Computer',
                        'route' => 'computer/edit',
                        'onlybread' => true,
                    ),
                    'show' => array(
                        'label' => 'Mostra Computer',
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
                ),
            ),
        ),
    ),
);
