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
use Doctrine\ORM\Tools\Pagination\Paginator as ORMPaginator;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator;
//Form
use Samples\Form\SampleForm;
use Application\Form\SearchForm;


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
        $searchform = new SearchForm();
        $searchform->get('submit')->setValue('Search');
        $search_by = $this->params()->fromRoute('search_by') ? $this->params()->fromRoute('search_by') : '';
        $searchString = '';
        $formdata = [];
        if (!empty($search_by)) {
            $formdata = (array) json_decode($search_by);
            if (isset($formdata['search'])) {
                $searchString = trim($formdata['search']);
            }
        }    

        $order_by = $this->params()->fromRoute('order_by') ? $this->params()->fromRoute('order_by') : 'id';
        $order = $this->params()->fromRoute('order') ? $this->params()->fromRoute('order') : 'DESC';
        $page = $this->params()->fromRoute('page') ? (int) $this->params()->fromRoute('page') : 1;  

        $paginator = new Paginator\Paginator(
            new DoctrinePaginator(new ORMPaginator($this->sampleMapper->getSearchQuery($searchString, 's.' . $order_by, $order)))
        );

        $paginator->setItemCountPerPage(30);
        $paginator->setCurrentPageNumber($this->getEvent()->getRouteMatch()->getParam('page'));
        
        $searchform->setData($formdata);
        return array(
            'search_by' => $search_by,
            'order_by' => $order_by,
            'order' => $order,
            'page' => $page,
            'totalRecord' => $paginator->getTotalItemCount(),                        
            'samples' => $paginator,
            'form' => $searchform,
            'pageAction' => 'samples/list',
        );        
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
        
        //Setto richiedente
        $form->get('sample')->get('applicant')->setValue($this->zfcUserAuthentication()->getIdentity()->getId());

        $form->get('sample')->get('status')->setValue(\Samples\Entity\Status::STATUS_TYPE_PENDING_EVASION);

        if ($this->request->isPost()) {
            $form->setData($this->request->getPost());
            if ($form->isValid()) {
                $this->sampleMapper->insert($sample);

                $this->flashMessenger()->setNamespace('success')->addMessage('Richesta di campionatura aggiunta con successo');
                
                return $this->redirect()->toRoute('samples/attachments/add', array(
                    'controller' => 'attachment',
                    'action' =>  'add',
                    'sample_id' => $sample->getId(),
                    'type'=> \Samples\Entity\Attachments::ATTACHMENT_TYPE_REQUEST
                ));
                
                //return $this->redirect()->toRoute('samples/list');
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
    
    /**
     * Usata per formattare una ricerca. Poteva essere + semplice ma in partenza 
     * precedeva + campi. Ho lasciato il codice originale.
     */
    public function searchAction()
    {
        $request = $this->getRequest();
        $url = 'list';

        if ($request->isPost()) {
            $formdata = (array) $request->getPost();
            $search_data = array();
            foreach ($formdata as $key => $value) {
                if ($key != 'submit') {
                    if (!empty($value)) {
                        $search_data[$key] = trim($value);
                    }
                }
            }
            if (!empty($search_data)) {
                $search_by = json_encode($search_data);
                $url .= '/search_by/' . $search_by;
            }
        }
        $this->redirect()->toUrl($url);
    }      

   
}
