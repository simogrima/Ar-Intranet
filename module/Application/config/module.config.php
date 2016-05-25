<?php
namespace Application;

return array(
    'service_manager' => array(
        'factories' => array(
            'left_navigation' => 'Application\Navigation\Service\LeftNavigationFactory',
            'Application\Options\ModuleOptions' => 'Application\Factory\ModuleOptionsFactory',
            'Application\Mapper\SuppliersMapper' => 'Application\Factory\SuppliersMapperFactory',
        ),        
        'abstract_factories' => array(
            'Zend\Cache\Service\StorageCacheAbstractServiceFactory',
            'Zend\Log\LoggerAbstractServiceFactory',
        ),
        'aliases' => array(
            'translator' => 'MvcTranslator',
        ),
    ),

    'controllers' => array(
        'invokables' => array(
            'Application\Controller\Index' => 'Application\Controller\IndexController'
        ),
        'factories' => array(
            'Application\Controller\Suppliers' => 'Application\Factory\Controller\SuppliersControllerFactory',
        ),        
    ),    

  
    'router' => array(
        'routes' => array(
            'home' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Index',
                        'action'     => 'index',
                    ),
                ),
            ),
            // The following is a route to simplify getting started creating
            // new controllers and actions without needing to create a new
            // module. Simply drop new controllers in, and you can access them
            // using the path /application/:controller/:action
            'application' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/application',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Application\Controller',
                        'controller'    => 'Index',
                        'action'        => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'default' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/[:controller[/:action]]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                            ),
                        ),
                    ),
                    
                    //suppliers
                    'suppliers' => array(
                        'type' => 'Literal',
                        'priority' => 1000,
                        'options' => array(
                            'route' => '/suppliers',
                            'defaults' => array(
                                'controller' => 'Application\Controller\Suppliers',
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
                                        'controller' => 'Application\Controller\Suppliers',
                                        'action' => 'list',
                                    ),
                                ),
                            ),
                            'search' => array(
                                'type' => 'Literal',
                                'options' => array(
                                    'route' => '/search',
                                    'defaults' => array(
                                        'controller' => 'Application\Controller\Suppliers',
                                        'action' => 'search',
                                    ),
                                ),
                            ),
                            'add' => array(
                                'type' => 'Segment',
                                'options' => array(
                                    'route' => '/add/:supplier_id',
                                    'constraints' => array(
                                        'supplier_id' => '[0-9]+',
                                        'type' => '[a-zA-Z][a-zA-Z0-9_\/-]*'
                                    ),
                                    'defaults' => array(
                                        'controller' => 'Application\Controller\Suppliers',
                                        'action' => 'add',
                                        'supplier_id' => 0,
                                    ),
                                ),
                            ),                            
                            'edit' => array(
                                'type' => 'Segment',
                                'options' => array(
                                    'route' => '/edit/:supplierId',
                                    'defaults' => array(
                                        'controller' => 'Application\Controller\Suppliers',
                                        'action' => 'edit',
                                        'supplierId' => 0
                                    ),
                                ),
                            ),
                            'remove' => array(
                                'type' => 'Segment',
                                'options' => array(
                                    'route' => '/remove/:supplierId',
                                    'defaults' => array(
                                        'controller' => 'Application\Controller\Suppliers',
                                        'action' => 'remove',
                                        'supplierId' => 0
                                    ),
                                ),
                            ),                         
                        ),
                    ), // end suppliers                        
                    

                    
                    
                ),
            ),
        ),
    ),
    'translator' => array(
        'locale' => 'en_US',
        'translation_file_patterns' => array(
            array(
                'type'     => 'gettext',
                'base_dir' => __DIR__ . '/../language',
                'pattern'  => '%s.mo',
            ),
        ),
    ),
    'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => array(
            'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
            'application/index/index' => __DIR__ . '/../view/application/index/index.phtml',
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
   'view_helpers' => array(
        'invokables' => array(
            'titleAndBread' => 'Application\View\Helper\TitleAndBread',
            'myFlashMessenger' => 'Application\View\Helper\FlashMessenger',
            'truncateTxt' => 'Application\View\Helper\TruncateTxt',
      ),
   ), 
    // Placeholder for console routes
    'console' => array(
        'router' => array(
            'routes' => array(
            ),
        ),
    ),   
    'doctrine' => array(
        'driver' => array(
            'application_entities' => array(
                'paths' => array(
                    __DIR__ . '/../../Application/src/Application/Entity')
            ),
            'orm_default' => array(
                'drivers' => array(
                    'Application\Entity' => 'application_entities'
                )
            )
        ),
    ),    
    
    //My module options
    'application_opt' => [     
    ],    
    
    'navigation' => array(
        'leftnav' => array(
            'home' => array(
                'label' => 'Dashboard',
                'route' => 'home',
                'icon' => 'fa fa-dashboard fa-fw'
            ),   
            'suppliers' => array(
                'label' => 'Gestione fornitori',
                'route' => 'application/suppliers/list',
                'icon' => 'fa fa-truck fa-fw'
            ),              
        ),
    ),      
    
);
