<?php

/**
 * Prototyping\Controller\Index
 *
 * @author Simone Grimani
 * @copyright  Copyright (c) 2014 Simone Grimani (http://www.simogrima.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

namespace Prototyping\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Application\Controller\EntityUsingController;
use Prototyping\Entity\Prototyping;
use Zend\Paginator;
use Zend\Stdlib\Hydrator\ClassMethods;
use Zend\View\Model\ViewModel;
//Doctrine
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Doctrine\ORM\Tools\Pagination\Paginator as ORMPaginator;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator;
use DoctrineExtensions\Query\Mysql\Year;
//Form
use Prototyping\Form\PrototypingForm;
use Prototyping\Form\SearchForm;
//ZfcRbac
use ZfcRbac\Exception\UnauthorizedException;
//per migrazione dati
use Zend\Db\Sql\Sql;
use Zend\Db\Adapter\Adapter;

//fine per migrazione

class IndexController extends EntityUsingController
{

    /**
     * @var Prototyping\Options\ModuleOptions
     */
    protected $options;

    /**
     *
     * @var type Prototyping\Mapper\PrototypingMapper
     */
    protected $prototypingMapper;

    /**
     *
     * @var type Prototyping\Mapper\HistoryMapper
     */
    protected $historyMapper;

    public function __construct($options, $mapper, $mapperHistory)
    {
        $this->options = $options;
        $this->prototypingMapper = $mapper;
        $this->historyMapper = $mapperHistory;
    }
    
    public function indexAction()
    {
        return $this->redirect()->toUrl('/prototyping/list');
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
                new DoctrinePaginator(new ORMPaginator($this->prototypingMapper->getFieldsSearchQuery($formdata, 'p.' . $order_by, $order)))
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
            'pageAction' => 'prototyping/list',
            'showResetBtn' => (!empty($formdata)),
            'isEditor' => $this->getAuthorizationService()->isGranted('prototyping.edit'),
        );
    }
        
    public function createAction()
    {
        $objectManager = $this->getEntityManager();

        // Create the form and inject the ObjectManager
        $form = new PrototypingForm($objectManager);

        // Create a new, empty entity and bind it to the form
        $class = $this->options->getPrototypingEntityClass();
        $prototyping = new $class();
        $form->bind($prototyping);

        //Setto stato
        //$form->get('prototyping')->get('status')->setValue(\Prototyping\Entity\Status::STATUS_TYPE_REQUIRED);

        if ($this->request->isPost()) {
            $form->setData($this->request->getPost());

            if ($form->isValid()) {
                //setto default
                $statusRepo = $objectManager->getRepository('Prototyping\Entity\Status');
                $prototyping->setStatus($statusRepo->find(\Prototyping\Entity\Status::STATUS_TYPE_REQUIRED));
                //per ora la data inizio viene da form
                //$prototyping->setCreatedDate(new \Datetime()); //setto data creazione qua xche mi serve sotto  

                //***** History
                $data = array(
                    'prototyping' => $prototyping,
                    'editBy' => $this->getServiceLocator()->get('zfcuser_user_mapper')
                            ->findById($this->zfcUserAuthentication()
                                    ->getIdentity()->getId()),
                    'prototypingStatus' => $prototyping->getStatus(),
                    'editDate' => new \DateTime('NOW'),
                );

                //Aggiungo un record per nuova richiesta
                $this->addHistory($data);
                //***** Fine History           


                $this->prototypingMapper->insert($prototyping);

                //Notifica via email
                //$this->prototypingMapper->sendNewSampleEmail($sample, $this, $this->zfcUserAuthentication()->getIdentity());


                return $this->redirect()->toRoute('prototyping/attachments/add', array(
                            'controller' => 'attachment',
                            'action' => 'add',
                            'prototyping_id' => $prototyping->getId(),
                ));

                //return $this->redirect()->toRoute('prototyping/list');
            }
        }

        return array('form' => $form, 'isPost' => $this->request->isPost());
    }

    public function editAction()
    {
        //Solo autorizzai (permissione: prototyping.edit)
        if (!$this->getAuthorizationService()->isGranted('prototyping.edit')) {
            throw new UnauthorizedException();
        }

        // Get your ObjectManager from the ServiceManager
        $objectManager = $this->getEntityManager();

        $prototypingId = $this->getEvent()->getRouteMatch()->getParam('prototypingId');
        $prototyping = $objectManager->getRepository($this->options->getPrototypingEntityClass())->find($prototypingId);

        if (!$prototyping) {
            throw new \Exception('Prova non trovata!');
        }

        // Create the form and inject the ObjectManager
        $form = new PrototypingForm($objectManager);

        $form->bind($prototyping);

        if ($this->request->isPost()) {
            $postedData = $this->request->getPost();
            $form->setData($postedData);
            if ($form->isValid()) {
                $prototyping->setEditDate(new \Datetime()); //setto data ultima modifica   ;

                //********* History *******/
                //Controllo le modifiche
                $uow = $objectManager->getUnitOfWork();
                $uow->computeChangeSets();
                $changeset = $uow->getEntityChangeSet($prototyping);
                $data = array(
                    'prototyping' => $prototyping,
                    'editBy' => $this->getServiceLocator()->get('zfcuser_user_mapper')
                            ->findById($this->zfcUserAuthentication()
                                    ->getIdentity()->getId()),
                    'prototypingStatus' => $prototyping->getStatus(),
                    'editDate' => new \DateTime('NOW'),
                );
                //Cambio stato
                if (isset($changeset['status'])) {
                    //Aggiungo un record per cambio stato
                    $this->addHistory($data);   
                    
                    //Se conclusa setto data fune su tabella prototyping altrimenti setto su null
                    if ($prototyping->getStatus()->getId() == \Prototyping\Entity\Status::STATUS_TYPE_CLOSED) {
                        $prototyping->setEndDate(new \Datetime());
                    } else {
                        $prototyping->setEndDate(NULL);
                    }                 
                    
                    
                }
                //***** Fine History *****/    


                $this->prototypingMapper->update($prototyping);

                $this->flashMessenger()->setNamespace('success')->addMessage('Modifica eseguita con successo');
                return $this->redirect()->toRoute('prototyping/edit', array('prototypingId' => $prototyping->getId()));
            } else {
                //var_dump($form->getMessages());
            }
        }

        return array(
            'form' => $form,
            'prototyping' => $prototyping,
            'attachmentPath' => $this->options->getAttachmentPath(),
        );
    }

    public function removeAction()
    {
        //Solo autorizzai (permissione: prototyping.remove)
        if (!$this->getAuthorizationService()->isGranted('prototyping.remove')) {
            throw new UnauthorizedException();
        }

        $objectManager = $this->getEntityManager();

        $prototypingId = $this->getEvent()->getRouteMatch()->getParam('prototypingId');
        $prototyping = $objectManager->getRepository($this->options->getPrototypingEntityClass())->find($prototypingId);

        if ($prototyping) {
            $this->prototypingMapper->remove($prototyping);
            $this->flashMessenger()->addSuccessMessage('La prova è stata eliminata!');
        }

        return $this->redirect()->toRoute('prototyping/list');
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
        $prototypingId = $this->getEvent()->getRouteMatch()->getParam('prototypingId');
        $historyType = (int) $this->getEvent()->getRouteMatch()->getParam('historyType');
        $prototyping = $this->getEntityManager()->getRepository($this->options->getPrototypingEntityClass())->find($prototypingId);

        if (!$prototyping) {
            throw new \Exception('Prova non trovata!');
        }

        return array(
            'prototyping' => $prototyping,
            'historyType' => $historyType,
            'attachmentPath' => $this->options->getAttachmentPath(),
        );
    }

    public function printAction()
    {
        $prototypingId = $this->getEvent()->getRouteMatch()->getParam('prototypingId');
        $prototyping = $this->getEntityManager()->getRepository($this->options->getPrototypingEntityClass())->find($prototypingId);

        if (!$prototyping) {
            throw new \Exception('Prova non trovata!');
        }

        return array(
            'prototyping' => $prototyping,
            'attachmentPath' => $this->options->getAttachmentPath(),
        );
    }

    /**
     * Aggiunge un record alla tabella prototyping_history in caso di aggiunta o 
     * modifica prototyping.
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
