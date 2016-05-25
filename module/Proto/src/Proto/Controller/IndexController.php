<?php

/**
 * Proto\Controller\Index
 *
 * @author Simone Grimani
 * @copyright  Copyright (c) 2014 Simone Grimani (http://www.simogrima.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

namespace Proto\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Application\Controller\EntityUsingController;
use Proto\Entity\Proto;
use Zend\Paginator;
use Zend\Stdlib\Hydrator\ClassMethods;
use Zend\View\Model\ViewModel;
//Doctrine
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Doctrine\ORM\Tools\Pagination\Paginator as ORMPaginator;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator;
use DoctrineExtensions\Query\Mysql\Year;
//Form
use Proto\Form\ProtoForm;
use Proto\Form\SearchForm;
//ZfcRbac
use ZfcRbac\Exception\UnauthorizedException;
//per migrazione dati
use Zend\Db\Sql\Sql;
use Zend\Db\Adapter\Adapter;

//fine per migrazione

class IndexController extends EntityUsingController
{

    /**
     * @var Proto\Options\ModuleOptions
     */
    protected $options;

    /**
     *
     * @var type Proto\Mapper\ProtoMapper
     */
    protected $protoMapper;

    /**
     *
     * @var type Proto\Mapper\HistoryMapper
     */
    protected $historyMapper;

    public function __construct($options, $mapper, $mapperHistory)
    {
        $this->options = $options;
        $this->protoMapper = $mapper;
        $this->historyMapper = $mapperHistory;
    }
    
    public function indexAction()
    {
        return $this->redirect()->toUrl('/proto/list');
    }

    public function listAction()
    {
        $searchform = new SearchForm($this->getEntityManager());
        $searchform->get('submit')->setValue('Search');
        $search_by = $this->params()->fromRoute('search_by') ? $this->params()->fromRoute('search_by') : '';
        $searchString = '';
        $formdata = [];
        if (!empty($search_by)) {
            $formdata = (array) json_decode($search_by);
        }

        $order_by = $this->params()->fromRoute('order_by') ? $this->params()->fromRoute('order_by') : 'id';
        $order = $this->params()->fromRoute('order') ? $this->params()->fromRoute('order') : 'DESC';
        $page = $this->params()->fromRoute('page') ? (int) $this->params()->fromRoute('page') : 1;

        $paginator = new Paginator\Paginator(
                new DoctrinePaginator(new ORMPaginator($this->protoMapper->getFieldsSearchQuery($formdata, 'p.' . $order_by, $order)))
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
            'rows' => $paginator,
            'form' => $searchform,
            'pageAction' => 'proto/list',
            'showResetBtn' => (!empty($formdata)),
            'isEditor' => $this->getAuthorizationService()->isGranted('proto.edit'),
        );
    }
        
    public function createAction()
    {
        $objectManager = $this->getEntityManager();

        // Create the form and inject the ObjectManager
        $form = new ProtoForm($objectManager);

        // Create a new, empty entity and bind it to the form
        $class = $this->options->getProtoEntityClass();
        $proto = new $class();
        $form->bind($proto);

        //Setto stato
        $form->get('proto')->get('status')->setValue(\Proto\Entity\Status::STATUS_TYPE_REQUIRED);
        //Setto richiedente
        $form->get('proto')->get('applicant')->setValue($this->zfcUserAuthentication()->getIdentity()->getId());
     

        if ($this->request->isPost()) {
            $form->setData($this->request->getPost());

            if ($form->isValid()) {
                //setto default
                $statusRepo = $objectManager->getRepository('Proto\Entity\Status');
                $proto->setStatus($statusRepo->find(\Proto\Entity\Status::STATUS_TYPE_REQUIRED));
                //per ora la data inizio viene da form
                //$proto->setCreatedDate(new \Datetime()); //setto data creazione qua xche mi serve sotto  

                //***** History
                $data = array(
                    'proto' => $proto,
                    'editBy' => $this->getServiceLocator()->get('zfcuser_user_mapper')
                            ->findById($this->zfcUserAuthentication()
                                    ->getIdentity()->getId()),
                    'protoStatus' => $proto->getStatus(),
                    'editDate' => new \DateTime('NOW'),
                );

                //Aggiungo un record per nuova richiesta
                $this->addHistory($data);
                //***** Fine History           


                $this->protoMapper->insert($proto);


                //Notifica via email
                $this->protoMapper->sendNewRequestEmail($proto, $this, $this->zfcUserAuthentication()->getIdentity());

                return $this->redirect()->toRoute('proto/attachments/add', array(
                            'controller' => 'attachment',
                            'action' => 'add',
                            'entity_id' => $proto->getId(),
                            'type' => \Proto\Entity\Attachments::ATTACHMENT_TYPE_REQUEST
                ));
              

                //return $this->redirect()->toRoute('proto/list');
            }
        }

        return array('form' => $form, 'isPost' => $this->request->isPost());
    }

    public function editAction()
    {
        //Solo autorizzai (permissione: proto.edit)
        if (!$this->getAuthorizationService()->isGranted('proto.edit')) {
            throw new UnauthorizedException();
        }

        // Get your ObjectManager from the ServiceManager
        $objectManager = $this->getEntityManager();

        $protoId = $this->getEvent()->getRouteMatch()->getParam('protoId');
        $proto = $objectManager->getRepository($this->options->getProtoEntityClass())->find($protoId);

        if (!$proto) {
            throw new \Exception('Richiesta non trovata!');
        }

        // Create the form and inject the ObjectManager
        $form = new ProtoForm($objectManager, true);

        $form->bind($proto);

        if ($this->request->isPost()) {
            $postedData = $this->request->getPost();
            $form->setData($postedData);
            if ($form->isValid()) {
                $proto->setEditDate(new \Datetime()); //setto data ultima modifica   ;

                //********* History *******/
                //Controllo le modifiche
                $uow = $objectManager->getUnitOfWork();
                $uow->computeChangeSets();
                $changeset = $uow->getEntityChangeSet($proto);
                $data = array(
                    'proto' => $proto,
                    'editBy' => $this->getServiceLocator()->get('zfcuser_user_mapper')
                            ->findById($this->zfcUserAuthentication()
                                    ->getIdentity()->getId()),
                    'protoStatus' => $proto->getStatus(),
                    'editDate' => new \DateTime('NOW'),
                );
                //Cambio stato
                if (isset($changeset['status'])) {
                    //Aggiungo un record per cambio stato
                    $this->addHistory($data);   
                    
                    //Se conclusa setto data fune su tabella proto altrimenti setto su null
                    if ($proto->getStatus()->getId() == \Proto\Entity\Status::STATUS_TYPE_DELIVERED) {
                        $proto->setEndDate(new \Datetime());
                    } else {
                        $proto->setEndDate(NULL);
                    }               
                    
                    //Invio email cambio stato al richiedente
                    $this->protoMapper->sendChangeStatusEmail($proto, $this, $this->zfcUserAuthentication()->getIdentity());
                    
                }
                //***** Fine History *****/    


                $this->protoMapper->update($proto);

                $this->flashMessenger()->setNamespace('success')->addMessage('Modifica eseguita con successo');
                return $this->redirect()->toRoute('proto/edit', array('protoId' => $proto->getId()));
            } else {
                //var_dump($form->getMessages());
            }
        }

        return array(
            'form' => $form,
            'proto' => $proto,
            'attachmentPath' => $this->options->getAttachmentPath(),
        );
    }

    public function removeAction()
    {
        //Solo autorizzai (permissione: proto.remove)
        if (!$this->getAuthorizationService()->isGranted('proto.remove')) {
            throw new UnauthorizedException();
        }

        $objectManager = $this->getEntityManager();

        $protoId = $this->getEvent()->getRouteMatch()->getParam('protoId');
        $proto = $objectManager->getRepository($this->options->getProtoEntityClass())->find($protoId);

        if ($proto) {
            $this->protoMapper->remove($proto);
            $this->flashMessenger()->addSuccessMessage('La richiesta è stata eliminata!');
        }

        return $this->redirect()->toRoute('proto/list');
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

    public function showAction()
    {
        $protoId = $this->getEvent()->getRouteMatch()->getParam('protoId');
        $historyType = (int) $this->getEvent()->getRouteMatch()->getParam('historyType');
        $proto = $this->getEntityManager()->getRepository($this->options->getProtoEntityClass())->find($protoId);

        if (!$proto) {
            throw new \Exception('Richiesta non trovata!');
        }

        return array(
            'proto' => $proto,
            'historyType' => $historyType,
            'attachmentPath' => $this->options->getAttachmentPath(),
        );
    }

    public function printAction()
    {
        $protoId = $this->getEvent()->getRouteMatch()->getParam('protoId');
        $proto = $this->getEntityManager()->getRepository($this->options->getProtoEntityClass())->find($protoId);

        if (!$proto) {
            throw new \Exception('Richiesta non trovata!');
        }

        return array(
            'proto' => $proto,
            'attachmentPath' => $this->options->getAttachmentPath(),
        );
    }

    /**
     * Aggiunge un record alla tabella protot_history in caso di aggiunta o 
     * modifica proto.
     * 
     * @param array $data
     */
    protected function addHistory($data)
    {
        $historyClass = $this->options->getHistoryEntityClass();
        $history = new $historyClass();
        $hydrator = new DoctrineHydrator($this->getEntityManager(), $historyClass);
        $history = $hydrator->hydrate($data, $history);

        //var_dump($history);
        $this->historyMapper->update($history);
        //$this->flashMessenger()->setNamespace('success')->addMessage('History add successfully');
    }


}
