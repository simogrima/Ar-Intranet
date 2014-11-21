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
use ZfcUserDoctrineORM\Mapper\User as ZfcUserDoctrineMapper;

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

    /**
     *
     * @var type Computer\Mapper\HistoryMapper
     */
    protected $historyMapper;

    public function __construct($options, $mapper, $mapperHistory)
    {
        $this->options = $options;
        $this->computerMapper = $mapper;
        $this->historyMapper = $mapperHistory;
    }

    public function indexAction()
    {
        return array(
            'computerCount' => count($this->computerMapper->findAll()),
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




                /**** History ****/
                $uow = $objectManager->getUnitOfWork();
                $uow->computeChangeSets();
                $changeset = $uow->getEntityChangeSet($computer);
                $historyEditor = $this->getServiceLocator()->get('zfcuser_user_mapper')->findById($this->zfcUserAuthentication()->getIdentity()->getId());
                $recipient = $historyEditor = $this->getServiceLocator()->get('zfcuser_user_mapper')->findById(2);
                var_dump($changeset);
                $data = array(
                    'computer' => $computer,
                    'recipient' => 2,
                    'editby' => $historyEditor,
                );
                //se c'è il cambio stato
                if (isset($changeset['status'])) {
                    $data['type'] = 4;
                } else {
                    $data['type'] = 2;
                }
                $historyClass = $this->options->getHistoryEntityClass();
                $history = new $historyClass();
                $hydrator = new DoctrineHydrator($objectManager, $historyClass);



                $history = $hydrator->hydrate($data, $history);
                //var_dump($history);
                $this->historyMapper->update($history);
                $this->flashMessenger()->setNamespace('success')->addMessage('History add successfully');
                /****  Fine History ****/

                $computer->setEditdDate(new \Datetime()); //setto data ultima modifica
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
