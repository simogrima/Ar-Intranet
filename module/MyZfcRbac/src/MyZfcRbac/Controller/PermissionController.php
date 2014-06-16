<?php

namespace MyZfcRbac\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Paginator;
use Zend\Stdlib\Hydrator\ClassMethods;
use MyZfcRbac\Form\PermissionForm;

class PermissionController extends AbstractActionController
{

    /**
     * @var MyZfcRbac\Options\ModuleOptions
     */
    protected $options;
    
    /**
     *
     * @var type MyZfcRbac\Mapper\PermissionMapper
     */
    protected $permissionMapper;

    public function __construct($options, $mapper)
    {
        $this->options = $options;
        $this->permissionMapper = $mapper;
    }

    public function listAction()
    {
        $permissions = $this->permissionMapper->findAll();
        if (is_array($permissions)) {
            $paginator = new Paginator\Paginator(new Paginator\Adapter\ArrayAdapter($permissions));
        } else {
            $paginator = $permissions;
        }

        $paginator->setItemCountPerPage(30);
        $paginator->setCurrentPageNumber($this->getEvent()->getRouteMatch()->getParam('page'));
        return array(
            'permissions' => $paginator,
            'permissionlistElements' => $this->options->getPermissionListElements(),
            'pageAction' => 'zfcadmin/zfcrbacdmin/permission/list',
        );
    }

    public function createAction()
    {
        // Get your ObjectManager from the ServiceManager
        $objectManager = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');

        // Create the form and inject the ObjectManager
        $form = new PermissionForm($objectManager);

        // Create a new, empty entity and bind it to the form
        $class = $this->options->getPermissionEntityClass();
        $permission = new $class();
        $form->bind($permission);

        if ($this->request->isPost()) {
            $form->setData($this->request->getPost());
            if ($form->isValid()) {
                $this->permissionMapper->insert($permission);

                $this->flashMessenger()->setNamespace('success')->addMessage('Data added successfully');
                return $this->redirect()->toRoute('zfcadmin/zfcrbacdmin/permission/list');
            }
        }

        return array('form' => $form);
    }
    
    public function editAction()
    {
        // Get your ObjectManager from the ServiceManager
        $objectManager = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
        
        $permissionId = $this->getEvent()->getRouteMatch()->getParam('permissionId');
        $permission = $objectManager->getRepository($this->options->getPermissionEntityClass())->find($permissionId);

        // Create the form and inject the ObjectManager
        $form = new PermissionForm($objectManager, $permission->getId());
        $form->bind($permission);

        if ($this->request->isPost()) {
            $form->setData($this->request->getPost());
            if ($form->isValid()) {
                $this->permissionMapper->update($permission);

                $this->flashMessenger()->setNamespace('success')->addMessage('Data edit successfully');
                return $this->redirect()->toRoute('zfcadmin/zfcrbacdmin/permission/list');
            }
        }

        return array('form' => $form);
    }    

    public function removeAction()
    {
        // Get your ObjectManager from the ServiceManager
        $objectManager = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
        
        $permissionId = $this->getEvent()->getRouteMatch()->getParam('permissionId');
        $permission = $objectManager->getRepository($this->options->getPermissionEntityClass())->find($permissionId);

        if ($permission) {
            $this->permissionMapper->remove($permission);;
            $this->flashMessenger()->addSuccessMessage('The permission was deleted');            
        }

        return $this->redirect()->toRoute('zfcadmin/zfcrbacdmin/permission/list');
    }

}
