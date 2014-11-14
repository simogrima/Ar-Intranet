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
    protected $sampleMapper;

    public function __construct($options, $mapper)
    {
        $this->options = $options;
        $this->sampleMapper = $mapper;
    }    
    


    public function listAction()
    {
        $samples = $this->sampleMapper->findAll();
        if (is_array($samples)) {
            $paginator = new Paginator\Paginator(new Paginator\Adapter\ArrayAdapter($samples));
        } else {
            $paginator = $samples;
        }

        $paginator->setItemCountPerPage(30);
        $paginator->setCurrentPageNumber($this->getEvent()->getRouteMatch()->getParam('page'));
        return array(
            'samples' => $paginator,
            //'rolelistElements' => $this->options->getRoleListElements(),
            'pageAction' => 'samples/list',
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
        $sample = new $class();
        $form->bind($sample);

        if ($this->request->isPost()) {
            $form->setData($this->request->getPost());
            if ($form->isValid()) {
                $this->sampleMapper->insert($sample);

                $this->flashMessenger()->setNamespace('success')->addMessage('Computer added successfully');
                return $this->redirect()->toRoute('computer/index');
            }
        }

        return array('form' => $form);
    }    

    public function editAction()
    {
        // Get your ObjectManager from the ServiceManager
        $objectManager = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');

        $sampleId = $this->getEvent()->getRouteMatch()->getParam('sampleId');
        $sample = $objectManager->getRepository($this->options->getComputerEntityClass())->find($sampleId);

        // Create the form and inject the ObjectManager
        $form = new ComputerForm($objectManager);
        $form->bind($sample);

        if ($this->request->isPost()) {
            $postedData = $this->request->getPost();
            $form->setData($postedData);
            if ($form->isValid()) {

                $this->sampleMapper->update($sample);

                $this->flashMessenger()->setNamespace('success')->addMessage('Computer edit successfully');
                return $this->redirect()->toRoute('samples/list');
            }
        }

        return array('form' => $form);
    }

}
