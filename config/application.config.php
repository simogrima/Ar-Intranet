<?php
$env = getenv('APP_ENV') ?: 'production';

// Use the $env value to determine which modules to load
$modules = array(

        'DoctrineModule',
        'DoctrineORMModule',
        'ZfcBase',
        'ZfcUser',
        'ZfcUserDoctrineORM',
        'ZfcRbac',
        'ZfcTwitterBootstrap',
        'ZfcAdmin',
        'ZfcUserAdmin',
        'MainModule',
        'Application',
        'User',
        'MyZfcRbac',
        'Admin',
        'Samples',
        'Computer'
);
if ($env == 'development') {
    $modules[] = 'ZendDeveloperTools';
}

return array(
    'modules' => $modules,
    'module_listener_options' => array(
        'module_paths' => array(
            './module',
            './vendor'
        ),
        'config_glob_paths' => array(
            'config/autoload/{,*.}{global,local}.php'
        )
    )
);
