<?php
namespace Admin\Navigation\Service;

use Zend\Navigation\Service\DefaultNavigationFactory;

/**
 * Factory for the Admin admin navigation
 *
 * @package    Admin
 * @subpackage Navigation\Service
 */
class AdminNavigationFactory extends DefaultNavigationFactory
{
    protected function getName()
    {
        return 'myadmin';
    }
}
