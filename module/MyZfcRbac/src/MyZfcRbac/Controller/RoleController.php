<?php

namespace MyZfcRbac\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Paginator;
use Zend\Stdlib\Hydrator\ClassMethods;
use MyZfcRbac\Form\RoleForm;

class RoleController extends AbstractActionController
{

    /**
     * @var MyZfcRbac\Options\ModuleOptions
     */
    protected $options;

    /**
     *
     * @var type MyZfcRbac\Mapper\RoleMapper
     */
    protected $roleMapper;

    public function __construct($options, $mapper)
    {
        $this->options = $options;
        $this->roleMapper = $mapper;
    }

    public function listAction()
    {
        $roles = $this->roleMapper->findAll();
        if (is_array($roles)) {
            $paginator = new Paginator\Paginator(new Paginator\Adapter\ArrayAdapter($roles));
        } else {
            $paginator = $roles;
        }

        $paginator->setItemCountPerPage(30);
        $paginator->setCurrentPageNumber($this->getEvent()->getRouteMatch()->getParam('page'));
        return array(
            'roles' => $paginator,
            'rolelistElements' => $this->options->getRoleListElements(),
            'pageAction' => 'zfcadmin/zfcrbacdmin/role/list',
        );
    }

    public function createAction()
    {
        // Get your ObjectManager from the ServiceManager
        $objectManager = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');

        // Create the form and inject the ObjectManager
        $form = new RoleForm($objectManager);

        // Create a new, empty entity and bind it to the form
        $class = $this->options->getRoleEntityClass();
        $role = new $class();
        $form->bind($role);

        if ($this->request->isPost()) {
            $form->setData($this->request->getPost());
            if ($form->isValid()) {
                $this->roleMapper->insert($role);

                $this->flashMessenger()->setNamespace('success')->addMessage('Data added successfully');
                return $this->redirect()->toRoute('zfcadmin/zfcrbacdmin/role/list');
            }
        }

        return array('form' => $form);
    }

    public function editAction()
    {
        // Get your ObjectManager from the ServiceManager
        $objectManager = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');

        $roleId = $this->getEvent()->getRouteMatch()->getParam('roleId');
        $role = $objectManager->getRepository($this->options->getRoleEntityClass())->find($roleId);

        // Create the form and inject the ObjectManager
        $form = new RoleForm($objectManager, $role->getId());
        $form->bind($role);

        if ($this->request->isPost()) {
            $postedData = $this->request->getPost();
            $form->setData($postedData);
            if ($form->isValid()) {

                if (!isset($postedData['role']['permissions'])) {
                    $col = new \Doctrine\Common\Collections\ArrayCollection();
                    $role->setPermissions($col);
                }    
                $this->roleMapper->update($role);

                $this->flashMessenger()->setNamespace('success')->addMessage('Data edit successfully');
                return $this->redirect()->toRoute('zfcadmin/zfcrbacdmin/role/list');
            }
        }

        return array('form' => $form);
    }

    public function removeAction()
    {
        // Get your ObjectManager from the ServiceManager
        $objectManager = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');

        $roleId = $this->getEvent()->getRouteMatch()->getParam('roleId');
        $role = $objectManager->getRepository($this->options->getRoleEntityClass())->find($roleId);

        if ($role) {
            $this->roleMapper->remove($role);
            $this->flashMessenger()->addSuccessMessage('The role was deleted');
        }

        return $this->redirect()->toRoute('zfcadmin/zfcrbacdmin/role/list');
    }

}
