<?php
namespace User;

return array(
    'aliases' => array(
       'user' => __NAMESPACE__ . '\Controller\User',
    ),
    'invokables' => array(
        __NAMESPACE__ . '\Controller\User' => __NAMESPACE__ . '\Controller\UserController',
    ),
);