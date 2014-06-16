<?php
namespace MyZfcRbac;

use Zend\Mvc\Controller\ControllerManager;

return array(
    'factories' => array( 
        'permissionController' => 'MyZfcRbac\Factory\Controller\PermissionControllerFactory',    
        'roleController' => 'MyZfcRbac\Factory\Controller\RoleControllerFactory',
    ),
);