<?php

/**
 * Computer\Controller\History
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
use Computer\Form\HistoryForm;


class HistoryController extends EntityUsingController
{
    /**
     * @var Computer\Options\ModuleOptions
     */
    protected $options;

    /**
     *
     * @var type Computer\Mapper\HistoryMapper
     */
    protected $historyMapper;

    public function __construct($options, $mapper)
    {
        $this->options = $options;
        $this->historyMapper = $mapper;
    }    
    
    public function indexAction()
    {
        $history = $this->historyMapper->findAll();
        if (is_array($history)) {
            $paginator = new Paginator\Paginator(new Paginator\Adapter\ArrayAdapter($history));
        } else {
            $paginator = $history;
        }

        $paginator->setItemCountPerPage(30);
        $paginator->setCurrentPageNumber($this->getEvent()->getRouteMatch()->getParam('page'));
        return array(
            'history' => $paginator,
            'pageAction' => 'computer/history',
        );
    }    

    public function editAction()
    {
        // Get your ObjectManager from the ServiceManager
        $objectManager = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');

        $historyId = $this->getEvent()->getRouteMatch()->getParam('historyId');
        $history = $objectManager->getRepository($this->options->getHistoryEntityClass())->find($historyId);

        // Create the form and inject the ObjectManager
        $form = new HistoryForm($objectManager);
        $form->bind($history);
        $form->get('edit_by')->setValue($this->zfcUserAuthentication()->getIdentity()->getId());

        if ($this->request->isPost()) {
            $postedData = $this->request->getPost();
            $form->setData($postedData);
            if ($form->isValid()) {

                $this->historyMapper->update($history);

                $this->flashMessenger()->setNamespace('success')->addMessage('History edit successfully');
                return $this->redirect()->toRoute('computer/history');
            } else {
                var_dump($form->getValidationGroup());    
            }
        }

        return array('form' => $form);
    }
    
    public function removeAction()
    {
        // Get your ObjectManager from the ServiceManager
        $objectManager = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');

        $historyId = $this->getEvent()->getRouteMatch()->getParam('historyId');
        $history = $objectManager->getRepository($this->options->getHistoryEntityClass())->find($historyId);

        if ($history) {
            $this->historyMapper->remove($history);
            $this->flashMessenger()->addSuccessMessage('The history was deleted');
        }

        return $this->redirect()->toRoute('computer/history');
    }    

}
