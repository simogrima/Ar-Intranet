<?php

/**
 * Computer\Controller
 *
 * @author Simone Grimani
 * @copyright  Copyright (c) 2014 Simone Grimani (http://www.simogrima.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

namespace Computer\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Application\Controller\EntityUsingController;
//use Computer\Entity\Computer;
use Zend\Paginator;
use Zend\Stdlib\Hydrator\ClassMethods;


//Doctrine
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
//Form
use Computer\Form\ComputerForm;


class IndexController extends EntityUsingController
{
    /**
     * @var Computer\Options\ModuleOptions
     */
    protected $options;

    /**
     *
     * @var type Computer\Mapper\ComputerMapper
     */
    protected $computerMapper;

    public function __construct($options, $mapper)
    {
        $this->options = $options;
        $this->computerMapper = $mapper;
    }    
    
    public function indexAction()
    {
        return array(
            'computerCount' =>  count($this->computerMapper->findAll()),
        );
    }        

    public function listAction()
    {
        $computers = $this->computerMapper->findAll();
        if (is_array($computers)) {
            $paginator = new Paginator\Paginator(new Paginator\Adapter\ArrayAdapter($computers));
        } else {
            $paginator = $computers;
        }

        $paginator->setItemCountPerPage(30);
        $paginator->setCurrentPageNumber($this->getEvent()->getRouteMatch()->getParam('page'));
        return array(
            'computers' => $paginator,
            //'computerlistElements' => $this->options->getRoleListElements(),
            'pageAction' => 'computer/list',
        );
    }    

    public function createAction()
    {
        // Get your ObjectManager from the ServiceManager
        $objectManager = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');

        // Create the form and inject the ObjectManager
        $form = new ComputerForm($objectManager);

        // Create a new, empty entity and bind it to the form
        $class = $this->options->getComputerEntityClass();
        $computer = new $class();
        $form->bind($computer);

        if ($this->request->isPost()) {
            $form->setData($this->request->getPost());
            if ($form->isValid()) {
                $this->computerMapper->insert($computer);

                $this->flashMessenger()->setNamespace('success')->addMessage('Computer added successfully');
                return $this->redirect()->toRoute('computer/list');
            }
        }

        return array('form' => $form);
    }    

    public function editAction()
    {
        // Get your ObjectManager from the ServiceManager
        $objectManager = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');

        $computerId = $this->getEvent()->getRouteMatch()->getParam('computerId');
        $computer = $objectManager->getRepository($this->options->getComputerEntityClass())->find($computerId);

        // Create the form and inject the ObjectManager
        $form = new ComputerForm($objectManager);
        $form->bind($computer);

        if ($this->request->isPost()) {
            $postedData = $this->request->getPost();
            $form->setData($postedData);
            if ($form->isValid()) {

                $this->computerMapper->update($computer);

                $this->flashMessenger()->setNamespace('success')->addMessage('Computer edit successfully');
                //return $this->redirect()->toRoute('computer/list');
            }
        }

        return array('form' => $form);
    }
    
    public function removeAction()
    {
        // Get your ObjectManager from the ServiceManager
        $objectManager = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');

        $computerId = $this->getEvent()->getRouteMatch()->getParam('computerId');
        $computer = $objectManager->getRepository($this->options->getComputerEntityClass())->find($computerId);

        if ($computer) {
            $this->computerMapper->remove($computer);
            $this->flashMessenger()->addSuccessMessage('The computer was deleted');
        }

        return $this->redirect()->toRoute('computer/list');
    }    
    
    public function showAction()
    {
        // Get your ObjectManager from the ServiceManager
        $objectManager = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');

        $computerId = $this->getEvent()->getRouteMatch()->getParam('computerId');
        return array(
            'computer' => $objectManager->getRepository($this->options->getComputerEntityClass())->find($computerId)
            );
    }    
    
    public function settingsAction()
    {
        $categoryMapper = $this->getServiceLocator()->get('Computer\Mapper\CategoryMapper');
        $brandMapper = $this->getServiceLocator()->get('Computer\Mapper\BrandMapper');
        $processorMapper = $this->getServiceLocator()->get('Computer\Mapper\ProcessorMapper');
        
        return array(
            'categories' => $categoryMapper->findAll(),
            'brands' => $brandMapper->findAll(),
            'processors' => $processorMapper->findAll(),
        );
    }      

}
