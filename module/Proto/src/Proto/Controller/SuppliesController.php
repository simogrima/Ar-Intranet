<?php

/**
 * Proto\Controller\Supplies
 *
 * @author Simone Grimani
 * @copyright  Copyright (c) 2014 Simone Grimani (http://www.simogrima.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

namespace Proto\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Application\Controller\EntityUsingController;
use Proto\Entity\Supplies;
use Zend\Paginator;
use Zend\Stdlib\Hydrator\ClassMethods;
use Zend\View\Model\ViewModel;
//Doctrine
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Doctrine\ORM\Tools\Pagination\Paginator as ORMPaginator;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator;
//Form
use Proto\Form\SupplyForm;
use Application\Form\SearchForm;

//ZfcRbac
use ZfcRbac\Exception\UnauthorizedException;

class SuppliesController extends EntityUsingController
{

    /**
     * @var Proto\Options\ModuleOptions
     */
    protected $options;

    /**
     *
     * @var type Proto\Mapper\SuppliesMapper
     */
    protected $suppliesMapper;

    public function __construct($options, $mapper)
    {
        $this->options = $options;
        $this->suppliesMapper = $mapper;
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
                new DoctrinePaginator(new ORMPaginator($this->suppliesMapper->getSearchQuery($searchString, 's.' . $order_by, $order)))
        );

        $paginator->setItemCountPerPage(30);
        $paginator->setCurrentPageNumber($this->getEvent()->getRouteMatch()->getParam('page'));

        $searchform->setData($formdata);
        return array(
            'search_by' => $search_by,
            'order_by' => $order_by,
            'order' => $order,
            'page' => $page,
            'form' => $searchform,
            'totalRecord' => $paginator->getTotalItemCount(),
            'supplies' => $paginator,
            'pageAction' => 'proto/supplies/list',
            'isEditor' => $this->getAuthorizationService()->isGranted('proto.edit'),
        );
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

    public function editAction()
    {
        //Solo autorizzai (permissione: proto.edit)
        if (!$this->getAuthorizationService()->isGranted('proto.edit')) {
            throw new UnauthorizedException();
        }

        // Get your ObjectManager from the ServiceManager
        $objectManager = $this->getEntityManager();

        $supplyId = $this->getEvent()->getRouteMatch()->getParam('supplyId');
        $supply = $objectManager->getRepository($this->options->getSuppliesEntityClass())->find($supplyId);
        
        if (!$supply) {
            throw new \Exception(
            sprintf('Fornitura non trovata!')
            );
        }         

        // Create the form and inject the ObjectManager
        $form = new SupplyForm($objectManager);
        $form->bind($supply);
        $form->get('proto')->setValue($supply->getProto()->getId());



        if ($this->request->isPost()) {
            $postedData = $this->request->getPost();
            $form->setData($postedData);
            if ($form->isValid()) {
                
                $this->suppliesMapper->update($supply);
                $this->flashMessenger()->setNamespace('success')->addMessage('Fornitura modificata con successo');

                return $this->redirect()->toRoute('proto/edit', array('protoId' => $supply->getProto()->getId()));
            } else {
                var_dump($form->getValidationGroup());
            }
        }


        return array('form' => $form, 'proto' => $supply->getProto());
    }

    public function removeAction()
    {
        //Solo autorizzai (permissione: proto.edit)
        if (!$this->getAuthorizationService()->isGranted('proto.edit')) {
            throw new UnauthorizedException();
        }

        $supplyId = $this->getEvent()->getRouteMatch()->getParam('supplyId');
        $supply = $this->getEntityManager()->getRepository($this->options->getSuppliesEntityClass())->find($supplyId);

        if ($supply) {
            $this->suppliesMapper->remove($supply);
            $this->flashMessenger()->addSuccessMessage('La fornitura è stata eliminata');
        }

        //se provengo da scheda richiesta redirect lì.
        $redirectUrl = $url = $this->getRequest()->getHeader('Referer')->getUri();
        if (strpos($redirectUrl, 'proto/edit') !== false) {
            return $this->redirect()->toUrl($redirectUrl);
        }

        return $this->redirect()->toRoute('proto/supplies/list');
    }
    
    public function addAction()
    {
        $protoId = $this->getEvent()->getRouteMatch()->getParam('proto_id');
        $proto = $this->getServiceLocator()->get('Proto\Mapper\ProtoMapper')->find((int) $protoId);
        if (!$proto) {
            throw new \Exception(
            sprintf('Richiesta non trovata!')
            );
        }    
        
        $objectManager = $this->getEntityManager();
        $form = new SupplyForm($objectManager);        
        
        // Create a new, empty entity and bind it to the form
        $class = $this->options->getSuppliesEntityClass();
        $supply = new $class();
        $form->bind($supply);        
        $form->get('proto')->setValue($proto->getId());

        if ($this->getRequest()->isPost()) {
            $form->setData($this->request->getPost());

            if ($form->isValid()) {
                $this->suppliesMapper->insert($supply);
                //
                // ...Save the form...
                //
                //var_dump($form->getData());
                
                $this->flashMessenger()->setNamespace('success')->addMessage('Fornitura aggiunta con successo!');
                
                
                return $this->redirect()->toRoute('proto/attachments/add', array(
                            'controller' => 'attachment',
                            'action' => 'add',
                            'entity_id' => $supply->getId(),
                            'type' => \Proto\Entity\Attachments::ATTACHMENT_TYPE_SUPPLY
                ));                
                
                
                
                
                //return $this->redirect()->toRoute('proto/edit', array('protoId' => $proto->getId()));
                //return $this->redirectToSuccessPage($form->getData());
            }
        }    
        
        return array('form' => $form, 'proto' => $proto);
    }    
    
    public function attachmentsAction()
    {
        // Get your ObjectManager from the ServiceManager
        $objectManager = $this->getEntityManager();

        $supplyId = $this->getEvent()->getRouteMatch()->getParam('supplyId');
        $supply = $objectManager->getRepository($this->options->getSuppliesEntityClass())->find($supplyId);
        
        if (!$supply) {
            throw new \Exception(
            sprintf('Fornitura non trovata!')
            );
        }         
        return array(
            'rows' => $supply->getAttachments(),
            'attachmentPath' => $this->options->getAttachmentPath(),
            'isEditor' => $this->getAuthorizationService()->isGranted('proto.edit'),
        );
        
        
    }        

}
