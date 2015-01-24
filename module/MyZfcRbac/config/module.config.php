<?php
namespace MyZfcRbac;

return array(
    'service_manager' => array(
        'aliases' => array(
            'Zend\Authentication\AuthenticationService' => 'zfcuser_auth_service', // per settare come indentity provider quello di zfcuser
        ),        
        'factories' => array(
            'MyZfcRbac\View\Strategy\DynamicStrategy' => 'MyZfcRbac\Factory\DynamicStrategyFactory',
            'MyZfcRbac\Options\ModuleOptions' => 'MyZfcRbac\Factory\ModuleOptionsFactory',
            'MyZfcRbac\Mapper\PermissionMapper' => 'MyZfcRbac\Factory\PermissionMapperFactory',
            'MyZfcRbac\Mapper\RoleMapper' => 'MyZfcRbac\Factory\RoleMapperFactory',            
        ),        
    ),

    'view_manager' => [
        __NAMESPACE__ => __DIR__ . '/../view',
        'template_path_stack' => [__DIR__ . '/../view'],
    ],
    
    'router' => array(
        'routes' => array(
            'zfcadmin' => array(
                'child_routes' => array(
                    'zfcrbacdmin' => array(
                        'type' => 'Literal',
                        'priority' => 1000,
                        'options' => array(
                            'route' => '/rbac',
                        ),                     
                        'child_routes' => array(
                            
                            //Permission routes
                            'permission' => array(
                                'type' => 'Literal',
                                'priority' => 1000,
                                'options' => array(
                                    'route' => '/permission',
                                    'defaults' => array(
                                        'controller' => 'permissionController',
                                        'action' => 'list',
                                    ),
                                ),
                                'child_routes' => array(
                                    'list' => array(
                                        'type' => 'Segment',
                                        'options' => array(
                                            'route' => '/list[/:page]',
                                            'constraints' => array(
                                                'page' => '[0-9]+',
                                            ),
                                            'defaults' => array(
                                                'controller' => 'permissionController',
                                                'action' => 'list',
                                            ),
                                        ),
                                    ),
                                    'create' => array(
                                        'type' => 'Literal',
                                        'options' => array(
                                            'route' => '/create',
                                            'defaults' => array(
                                                'controller' => 'permissionController',
                                                'action' => 'create'
                                            ),
                                        ),
                                    ),
                                    'edit' => array(
                                        'type' => 'Segment',
                                        'options' => array(
                                            'route' => '/edit/:permissionId',
                                            'defaults' => array(
                                                'controller' => 'permissionController',
                                                'action' => 'edit',
                                                'userId' => 0
                                            ),
                                        ),
                                    ),
                                    'remove' => array(
                                        'type' => 'Segment',
                                        'options' => array(
                                            'route' => '/remove/:permissionId',
                                            'defaults' => array(
                                                'controller' => 'permissionController',
                                                'action' => 'remove',
                                                'userId' => 0
                                            ),
                                        ),
                                    ),
                                ),
                            ),//end permission routes
                            
                            //Role routes
                            'role' => array(
                                'type' => 'Literal',
                                'priority' => 1000,
                                'options' => array(
                                    'route' => '/role',
                                    'defaults' => array(
                                        'controller' => 'roleController',
                                        'action' => 'list',
                                    ),
                                ),
                                'child_routes' => array(
                                    'list' => array(
                                        'type' => 'Segment',
                                        'options' => array(
                                            'route' => '/list[/:page]',
                                            'constraints' => array(
                                                'page' => '[0-9]+',
                                            ),
                                            'defaults' => array(
                                                'controller' => 'roleController',
                                                'action' => 'list',
                                            ),
                                        ),
                                    ),
                                    'create' => array(
                                        'type' => 'Literal',
                                        'options' => array(
                                            'route' => '/create',
                                            'defaults' => array(
                                                'controller' => 'roleController',
                                                'action' => 'create'
                                            ),
                                        ),
                                    ),
                                    'edit' => array(
                                        'type' => 'Segment',
                                        'options' => array(
                                            'route' => '/edit/:roleId',
                                            'defaults' => array(
                                                'controller' => 'roleController',
                                                'action' => 'edit',
                                                'userId' => 0
                                            ),
                                        ),
                                    ),
                                    'remove' => array(
                                        'type' => 'Segment',
                                        'options' => array(
                                            'route' => '/remove/:roleId',
                                            'defaults' => array(
                                                'controller' => 'roleController',
                                                'action' => 'remove',
                                                'userId' => 0
                                            ),
                                        ),
                                    ),
                                ),
                            ),//end permission routes                            
                            
                            
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
                    __DIR__ . '/../../MyZfcRbac/src/MyZfcRbac/Entity')
            ),
            'orm_default' => array(
                'drivers' => array(
                    'MyZfcRbac\Entity' => 'application_entities'
                )
            )
        ),
    ),    
    
    /*
    'zfc_rbac' => [
        'guards' => [
            'ZfcRbac\Guard\RouteGuard' => [
                '*admin*' => ['admin']
            ]
        ],        
        'role_provider' => [
            'ZfcRbac\Role\InMemoryRoleProvider' => [
                'admin' => [
                    'children' => ['member'],
                    'permissions' => ['delete']
                ],
                'member' => [
                    'permissions' => ['edit']
                ]
            ]
        ]
    ]
     * 
     */

    'zfc_rbac' => [
        'redirect_strategy' => [
            'redirect_to_route_connected' => 'home',
            'redirect_to_route_disconnected' => 'zfcuser/login',
            'append_previous_uri' => true,
            'previous_uri_query_key' => 'redirect'
        ],
        'unauthorized_strategy' => [
            'template' => 'error/403.phtml'
        ],
        'role_provider' => [
            'ZfcRbac\Role\ObjectRepositoryRoleProvider' => [
                'object_manager' => 'doctrine.entitymanager.orm_default',
                'class_name' => __NAMESPACE__ . '\Entity\FlatRole',
                'role_name_property' => 'name'
            ]
        ],
        'guards' => [
            'ZfcRbac\Guard\RouteGuard' => [
                'zfcuser/login'    => ['guest'],
                'zfcuser/logout'   => ['guest'],
                'zfcuser/register' => ['guest'],
                '*admin*'          => ['admin'],
                '*'                => ['user'],
            ],
        ],
    ],    
    
    //My module options
    'myzfc_rbac' => [],
    
    'navigation' => array(
        'myadmin' => array(
            'zfcrbacadmin' => array(
                'label' => 'Security',
                'uri' => '',
                'icon' => 'glyphicon glyphicon-flash',
                'order' => 2,
                'pages' => array(
                    'role' => array(
                        'label' => 'Roles',
                        'route' => 'zfcadmin/zfcrbacdmin/role/list',
                    ),                    
                    'permission' => array(
                        'label' => 'Permissions',
                        'route' => 'zfcadmin/zfcrbacdmin/permission/list',
                    ),
                ),
            ),
        ),
    ),    
    
);
