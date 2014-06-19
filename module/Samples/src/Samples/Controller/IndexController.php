<?php

/**
 * Samples\Controller
 *
 * @author Simone Grimani
 * @copyright  Copyright (c) 2014 Simone Grimani (http://www.simogrima.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

namespace Samples\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Application\Controller\EntityUsingController;
use Samples\Entity\Sample;
use Zend\Paginator;
use Zend\Stdlib\Hydrator\ClassMethods;


//Doctrine
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
//Form
use Samples\Form\SampleForm;


class IndexController extends EntityUsingController
{
    /**
     * @var Samples\Options\ModuleOptions
     */
    protected $options;

    /**
     *
     * @var type Samples\Mapper\SampleMapper
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




    public function createOLDAction()
    {
        // Get your ObjectManager from the ServiceManager
        $objectManager = $this->getEntityManager();

        // Create the form and inject the ObjectManager
        $form = new CreateSampleForm($objectManager);
        
        // Create a new, empty entity and bind it to the form
        $sample = new Sample();
        $form->bind($sample);

        if ($this->request->isPost()) {
            $form->setData($this->request->getPost());

            if ($form->isValid()) {
                $objectManager->persist($sample);
                $objectManager->flush();
            }
        }


        return array('form' => $form);
    }
    
    public function createAction()
    {
        // Get your ObjectManager from the ServiceManager
        $objectManager = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');

        // Create the form and inject the ObjectManager
        $form = new SampleForm($objectManager);

        // Create a new, empty entity and bind it to the form
        $class = $this->options->getSampleEntityClass();
        $sample = new $class();
        $form->bind($sample);

        if ($this->request->isPost()) {
            $form->setData($this->request->getPost());
            if ($form->isValid()) {
                $this->sampleMapper->insert($sample);

                $this->flashMessenger()->setNamespace('success')->addMessage('Sample added successfully');
                return $this->redirect()->toRoute('samples/list');
            }
        }

        return array('form' => $form);
    }    

    public function editAction()
    {
        // Get your ObjectManager from the ServiceManager
        $objectManager = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');

        $sampleId = $this->getEvent()->getRouteMatch()->getParam('sampleId');
        $sample = $objectManager->getRepository($this->options->getSampleEntityClass())->find($sampleId);

        // Create the form and inject the ObjectManager
        $form = new SampleForm($objectManager);
        $form->bind($sample);

        if ($this->request->isPost()) {
            $postedData = $this->request->getPost();
            $form->setData($postedData);
            if ($form->isValid()) {

                $this->sampleMapper->update($sample);

                $this->flashMessenger()->setNamespace('success')->addMessage('Samples edit successfully');
                return $this->redirect()->toRoute('samples/list');
            }
        }

        return array('form' => $form);
    }

}
