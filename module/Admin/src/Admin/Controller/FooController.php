<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2013 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Admin\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class FooController extends AbstractActionController
{
    public function indexAction()
    {
        $identity = $this->identity();
        $roles = $identity->getRolesCollection();
        foreach ($roles as $role) {
            var_dump($role->getPermissions()->toArray());
            //var_dump($role->hasChildren());
        }
        
        $testPermission = $this->getServiceLocator()->get('User\Service\TestPermission');
        $testPermission->deleteUser();
        
        return new ViewModel();
    }
}
