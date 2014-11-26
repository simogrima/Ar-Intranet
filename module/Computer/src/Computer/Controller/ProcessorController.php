<?php

/**
 * Computer\Controller\Processor
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
use Computer\Form\ProcessorForm;


class ProcessorController extends EntityUsingController
{
    /**
     * @var Computer\Options\ModuleOptions
     */
    protected $options;

    /**
     *
     * @var type Computer\Mapper\ProcessorMapper
     */
    protected $processorMapper;

    public function __construct($options, $mapper)
    {
        $this->options = $options;
        $this->processorMapper = $mapper;
    }    
    
    public function indexAction()
    {
        $processors = $this->processorMapper->findAll();
        if (is_array($processors)) {
            $paginator = new Paginator\Paginator(new Paginator\Adapter\ArrayAdapter($processors));
        } else {
            $paginator = $processors;
        }

        $paginator->setItemCountPerPage(30);
        $paginator->setCurrentPageNumber($this->getEvent()->getRouteMatch()->getParam('page'));
        return array(
            'processors' => $paginator,
            'pageAction' => 'computer/processor',
        );
    }    

    public function createAction()
    {
        // Create the form and inject the ObjectManager
        $form = new ProcessorForm($this->getEntityManager());

        // Create a new, empty entity and bind it to the form
        $class = $this->options->getProcessorEntityClass();
        $processor = new $class();
        $form->bind($processor);

        if ($this->request->isPost()) {
            $form->setData($this->request->getPost());
            if ($form->isValid()) {
                $this->processorMapper->insert($processor);

                $this->flashMessenger()->setNamespace('success')->addMessage('Processor added successfully');
                return $this->redirect()->toRoute('computer/processor');
            }
        }

        return array('form' => $form);
    }    

    public function editAction()
    {
        // Get your ObjectManager from the ServiceManager
        $objectManager = $this->getEntityManager();

        $processorId = $this->getEvent()->getRouteMatch()->getParam('processorId');
        $processor = $objectManager->getRepository($this->options->getProcessorEntityClass())->find($processorId);

        // Create the form and inject the ObjectManager
        $form = new ProcessorForm($objectManager);
        $form->bind($processor);

        if ($this->request->isPost()) {
            $postedData = $this->request->getPost();
            $form->setData($postedData);
            if ($form->isValid()) {

                $this->processorMapper->update($processor);

                $this->flashMessenger()->setNamespace('success')->addMessage('Processor edit successfully');
                return $this->redirect()->toRoute('computer/processor');
            }
        }

        return array('form' => $form);
    }
    
    public function removeAction()
    {
        $processorId = $this->getEvent()->getRouteMatch()->getParam('processorId');
        $processor = $this->getEntityManager()->getRepository($this->options->getProcessorEntityClass())->find($processorId);

        if ($processor) {
            $this->processorMapper->remove($processor);
            $this->flashMessenger()->addSuccessMessage('The processor was deleted');
        }

        return $this->redirect()->toRoute('computer/processor');
    }    

}
