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
use Zend\View\Model\ViewModel;
//Doctrine
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Doctrine\ORM\Tools\Pagination\Paginator as ORMPaginator;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator;
use DoctrineExtensions\Query\Mysql\Year;
//Form
use Samples\Form\SampleForm;
use Samples\Form\SearchForm;
//ZfcRbac
use ZfcRbac\Exception\UnauthorizedException;
//per migrazione dati
use Zend\Db\Sql\Sql;
use Zend\Db\Adapter\Adapter;

//fine per migrazione

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

    /**
     *
     * @var type Samples\Mapper\HistoryMapper
     */
    protected $historyMapper;

    public function __construct($options, $mapper, $mapperHistory)
    {
        $this->options = $options;
        $this->sampleMapper = $mapper;
        $this->historyMapper = $mapperHistory;
    }

    public function indexAction()
    {
        $paginator = new Paginator\Paginator(
                new DoctrinePaginator(new ORMPaginator($this->sampleMapper->getSearchQuery('', 's.id', 'DESC')))
        );

        $paginator->setItemCountPerPage(20);
        $paginator->setCurrentPageNumber(1);

        $processedStatus = [
            \Samples\Entity\Status::STATUS_TYPE_PROCESSED,
            \Samples\Entity\Status::STATUS_TYPE_SHIPPED
        ];

        //ottengo tutti gli stati (per fixare grafico a torta)
        $objectManager = $this->getEntityManager();
        $statusList = $objectManager->getRepository('Samples\Entity\Status')->findAll();

        $config = $this->getEntityManager()->getConfiguration();
        $config->addCustomStringFunction('YEAR', 'DoctrineExtensions\Query\Mysql\Year');
        $config->addCustomStringFunction('MONTH', 'DoctrineExtensions\Query\Mysql\Month');

        $queryPieStatusY = $this->getEntityManager()->createQuery('SELECT COUNT(s.id) nr, t.name, t.id id FROM Samples\Entity\Sample s JOIN s.status t WHERE YEAR(s.createdDate) = ' . date('Y') . ' GROUP BY s.status');
        //$queryProcessedCount = $this->getEntityManager()->createQuery('SELECT COUNT(s.id) nr FROM Samples\Entity\Sample s WHERE s.status IN (' . implode(',', $processedStatus) . ')');
        //$queryPendingCount = $this->getEntityManager()->createQuery('SELECT COUNT(s.id) nr FROM Samples\Entity\Sample s WHERE s.status < ' . \Samples\Entity\Status::STATUS_TYPE_PROCESSED);
        //$queryCancelCount = $this->getEntityManager()->createQuery('SELECT COUNT(s.id) nr FROM Samples\Entity\Sample s WHERE s.status = ' . \Samples\Entity\Status::STATUS_TYPE_CANCELED);
        $queryStatCountByYear = $this->getEntityManager()->createQuery('SELECT COUNT(s.id) nr, SUM(s.qta) tot, YEAR(s.createdDate) y FROM Samples\Entity\Sample s GROUP BY y');

        $year = $this->params()->fromQuery('year', date('Y'));
        
        $queryStatCountByMonth = $this->getEntityManager()->createQuery('SELECT COUNT(s.id) nr, SUM(s.qta) tot, MONTH(s.createdDate) m FROM Samples\Entity\Sample s WHERE YEAR(s.createdDate) = ' . $year . ' GROUP BY m');

        return array(
            'sampleCount' => $this->sampleMapper->count(),
            //'processedCount' => $queryProcessedCount->getResult()[0]['nr'],
            //'pendingCount' => $queryPendingCount->getResult()[0]['nr'],
            //'cancelCount' => $queryCancelCount->getResult()[0]['nr'],
            'chartPieStatusY' => $this->fixPieValue($statusList, $queryPieStatusY->getResult()),
            'chartStatCountByYear' => $queryStatCountByYear->getResult(),
            'chartStatCountByMonth' => $queryStatCountByMonth->getResult(),
            'samples' => $paginator,
            'year' => $year,
        );
    }

    /**
     * Serve per fixare i valori del grafico a torta, che provengono da query con group by "status".
     * potrebba mancare uno elemento se nessu ordine si trova in uno degli statu disponibili. Io voglio che siano
     * rappresentati tutti sul grafico e se non c'è viene valorizzato a zero. Sennò sbaglia i colori.
     * 
     * @param array $statusList l'elenco completo degli stati disponibili
     * @param array $data i dati provenienti d query a (cui potrebbe mancare degli stati)
     * @return array
     */
    protected function fixPieValue($statusList, $data)
    {
        if (empty($data))
            return $data;

        $result = [];
        foreach ($statusList as $status) {
            $find = 0;
            foreach ($data as $value) {
                if ($value['id'] == $status->getId()) {
                    $find = $value['nr'];
                    break;
                }
            }

            $result[$status->getId()] = ['nr' => $find, 'name' => $status->getName()];
        }

        return $result;
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
                new DoctrinePaginator(new ORMPaginator($this->sampleMapper->getFieldsSearchQuery($formdata, 's.' . $order_by, $order)))
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
            'showResetBtn' => (!empty($formdata)),
        );
    }

    public function updateAction()
    {
        //Solo autorizzai (permissione: samples.edit)
        if (!$this->getAuthorizationService()->isGranted('samples.edit')) {
            throw new UnauthorizedException();
        }

        //Mostro Form Comunicazione
        if ($this->params()->fromQuery('comunicate', NULL)) {
            $ids = $this->params()->fromQuery('selected', NULL);
            if (!isset($ids)) {
                $this->flashMessenger()->setNamespace('error')->addMessage('Nessuna campionatura selezionata!');
                return $this->redirect()->toRoute('samples/update');
            } else {
                $qb = $this->getEntityManager()->createQueryBuilder();
                $qb->select('s')
                        ->from($this->options->getSampleEntityClass(), 's')
                        ->where($qb->expr()->in('s.id', $ids));
                return array(
                    'samples' => $qb->getQuery()->getResult(),
                    'ids' => implode(',', $ids),
                    'showComunicateForm' => 1,
                );
            }
        }
        //Fine Mostro Form Comunicazione
        //Sono in submit form 
        if ($this->request->isPost()) {
            //Vuo,dire che provengo da form per invio email
            //if ($this->params()->fromPost('peso', NULL)) {
            $ids = $this->params()->fromPost('selected', NULL);

            $cambioStato = 0;
            if (isset($ids)) {

                $qb = $this->getEntityManager()->createQueryBuilder();
                $qb->select('s')
                        ->from($this->options->getSampleEntityClass(), 's')
                        ->where($qb->expr()->in('s.id', $ids));
                $samples = $qb->getQuery()->getResult();
                //ottengo ed aggiorno al nuovo stato
                $statusRepo = $this->getEntityManager()->getRepository('Samples\Entity\Status');
                $status = $statusRepo->find(\Samples\Entity\Status::STATUS_TYPE_PRODUCT_REQUIRED);

                foreach ($samples as $sample) {
                    $cambioStato++;
                    $sample->setStatus($status);
                    $this->sampleMapper->update($sample);

                    //********* History *******/
                    $data = array(
                        'sample' => $sample,
                        'editBy' => $this->getServiceLocator()->get('zfcuser_user_mapper')
                                ->findById($this->zfcUserAuthentication()
                                        ->getIdentity()->getId()),
                        'sampleStatus' => $status,
                        'editDate' => new \DateTime('NOW'),
                    );

                    //Aggiungo un record per cambio stato
                    $this->addHistory($data);
                    //***** Fine History *****/                          
                }
            }
            $this->sampleMapper->sendProductRequiredEmail($this->params()->fromPost(), $this, $this->zfcUserAuthentication()->getIdentity());
            $this->flashMessenger()->setNamespace('success')->addMessage("La comunicazione è stata inviata. $cambioStato campionature hanno cambiato stato.");
            return $this->redirect()->toRoute('samples/update');
            //}
        }
        //Fine sono in submit form
        //Default lista campionature x aggiorna dati    
        $order_by = $this->params()->fromRoute('order_by') ? $this->params()->fromRoute('order_by') : 'id';
        $order = $this->params()->fromRoute('order') ? $this->params()->fromRoute('order') : 'DESC';
        $page = $this->params()->fromRoute('page') ? (int) $this->params()->fromRoute('page') : 1;

        $paginator = new Paginator\Paginator(
                new DoctrinePaginator(new ORMPaginator($this->sampleMapper->getActive('s.' . $order_by, $order)))
        );

        $paginator->setItemCountPerPage(1000);
        $paginator->setCurrentPageNumber($this->getEvent()->getRouteMatch()->getParam('page'));

        return array(
            'order_by' => $order_by,
            'order' => $order,
            'page' => $page,
            'totalRecord' => $paginator->getTotalItemCount(),
            'samples' => $paginator,
            'pageAction' => 'samples/update',
        );
    }
    
    public function processingAction()
    {
        //Solo autorizzai (permissione: samples.ship)
        if (!$this->getAuthorizationService()->isGranted('samples.edit')) {
            throw new UnauthorizedException();
        }        
        
        //Sono in submit form 
        if ($this->request->isPost()) {
            $ids = $this->params()->fromPost('selected', NULL);

            if (!isset($ids)) {
                $this->flashMessenger()->setNamespace('error')->addMessage('Nessuna campionatura selezionata!');
                return $this->redirect()->toRoute('samples/processing');
            } else {
                $qb = $this->getEntityManager()->createQueryBuilder();
                $qb->select('s')
                        ->from($this->options->getSampleEntityClass(), 's')
                        ->where($qb->expr()->in('s.id', $ids));
                $samples = $qb->getQuery()->getResult();

                foreach ($samples as $sample) {
                    $sample->setEmail2(1);
                    $this->sampleMapper->update($sample);                     
                }
            }
            $this->sampleMapper->sendProcessedSampleEmail($samples, $this, $this->zfcUserAuthentication()->getIdentity());
            $this->flashMessenger()->setNamespace('success')->addMessage("La comunicazione è stata inviata.");
            return $this->redirect()->toRoute('samples/processing');
        }        
        //Fine sono in submit form
        
        //Default lista campionature evase da comunicare a magazzino
        $order_by = $this->params()->fromRoute('order_by') ? $this->params()->fromRoute('order_by') : 'id';
        $order = $this->params()->fromRoute('order') ? $this->params()->fromRoute('order') : 'DESC';
        $page = $this->params()->fromRoute('page') ? (int) $this->params()->fromRoute('page') : 1;

        $paginator = new Paginator\Paginator(
                new DoctrinePaginator(new ORMPaginator($this->sampleMapper->getProcessed('s.' . $order_by, $order)))
        );

        $paginator->setItemCountPerPage(1000);
        $paginator->setCurrentPageNumber($this->getEvent()->getRouteMatch()->getParam('page'));

        return array(
            'order_by' => $order_by,
            'order' => $order,
            'page' => $page,
            'totalRecord' => $paginator->getTotalItemCount(),
            'samples' => $paginator,
            'pageAction' => 'samples/update',
        );
    }    

    public function shipAction()
    {
        //Solo autorizzai (permissione: samples.ship)
        if (!$this->getAuthorizationService()->isGranted('samples.ship')) {
            throw new UnauthorizedException();
        }

        //Mostro Form Comunicazione
        if ($this->params()->fromQuery('comunicate', NULL)) {
            $ids = $this->params()->fromQuery('selected', NULL);
            if (!isset($ids)) {
                $this->flashMessenger()->setNamespace('error')->addMessage('Nessuna campionatura selezionata!');
                return $this->redirect()->toRoute('samples/ship');
            } else {
                $qb = $this->getEntityManager()->createQueryBuilder();
                $qb->select('s')
                        ->from($this->options->getSampleEntityClass(), 's')
                        ->where($qb->expr()->in('s.id', $ids));
                return array(
                    'samples' => $qb->getQuery()->getResult(),
                    'ids' => implode(',', $ids),
                    'showComunicateForm' => 1,
                );
            }
        }
        //Fine Mostro Form Comunicazione
        //Rimuovo flag email1 (sposto su)
        if ($this->params()->fromQuery('up', NULL)) {
            $id = $this->params()->fromQuery('sampleId', 0);
            $sample = $this->getEntityManager()->getRepository($this->options->getSampleEntityClass())->find($id);

            if ($sample) {
                $sample->setEmail1(0);
                $this->sampleMapper->update($sample);
                $this->flashMessenger()->addSuccessMessage('Operazione conclusa con successo');
            } else {
                $this->flashMessenger()->setNamespace('error')->addMessage('Campionatura non trovata!');
            }
            return $this->redirect()->toRoute('samples/ship');
        }
        //Fine Rimuovo flag email1 (sposto su)       
        //Sono in submit form 
        if ($this->request->isPost()) {
            //Vuo,dire che provengo da form per invio email
            //if ($this->params()->fromPost('peso', NULL)) {
            $qb = $this->getEntityManager()->createQueryBuilder();
            $qb->select('s')
                    ->from($this->options->getSampleEntityClass(), 's')
                    ->where($qb->expr()->in('s.id', explode(',', $this->params()->fromPost('ids', []))));
            $samples = $qb->getQuery()->getResult();
            foreach ($samples as $sample) {
                $sample->setEmail1(1);
                $this->sampleMapper->update($sample);
            }
            $this->sampleMapper->sendShippingReadyEmail($samples, $this->params()->fromPost(), $this, $this->zfcUserAuthentication()->getIdentity());
            $this->flashMessenger()->setNamespace('success')->addMessage('La comunicazione è stata inviata. Ora le campionature possono essere spedite.');
            return $this->redirect()->toRoute('samples/ship');
            //}
        }
        //Fine sono in submit form
        //Default lista campionature da gestire x spedizione
        $order_by = $this->params()->fromRoute('order_by') ? $this->params()->fromRoute('order_by') : 'disabled';
        $order = $this->params()->fromRoute('order') ? $this->params()->fromRoute('order') : 'DESC';
        $page = $this->params()->fromRoute('page') ? (int) $this->params()->fromRoute('page') : 1;

        $paginator = new Paginator\Paginator(
                new DoctrinePaginator(new ORMPaginator($this->sampleMapper->getToShip('s.' . $order_by, $order)))
        );

        $paginator->setItemCountPerPage(1000);
        $paginator->setCurrentPageNumber($this->getEvent()->getRouteMatch()->getParam('page'));

        return array(
            'order_by' => $order_by,
            'order' => $order,
            'page' => $page,
            'totalRecord' => $paginator->getTotalItemCount(),
            'samples' => $paginator,
            'pageAction' => 'samples/ship',
        );
    }

    public function createAction()
    {
        $objectManager = $this->getEntityManager();

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
                $sample->setPainting('0');
                $sample->setToBeSerigraphy('0');
                $sample->setEmail1('0');
                $sample->setEmail2('0');
                $sample->setCreatedDate(new \Datetime()); //setto data creazione qua xche mi serve sotto  
                $sample->setCurrentStatusDate(new \Datetime());
                $sample->setScheduledDeliveryDate(new \DateTime($this->generateScheduledDeliveryDate($sample)));

                //$myDateTime = DateTime::createFromFormat('d/m/Y', $this->params()->fromQuery('requestedDeliveryDate', date('d/m/Y')));
                //$sample->setRequestedDeliveryDate($myDateTime->format('d-m-Y'));
                //***** History
                $data = array(
                    'sample' => $sample,
                    'editBy' => $this->getServiceLocator()->get('zfcuser_user_mapper')
                            ->findById($this->zfcUserAuthentication()
                                    ->getIdentity()->getId()),
                    'sampleStatus' => $sample->getStatus(),
                    'editDate' => new \DateTime('NOW'),
                );

                //Aggiungo un record per nuova richiesta
                $this->addHistory($data);
                //***** Fine History           


                $this->sampleMapper->insert($sample);

                //Notifica via email
                $this->sampleMapper->sendNewSampleEmail($sample, $this, $this->zfcUserAuthentication()->getIdentity());


                return $this->redirect()->toRoute('samples/attachments/add', array(
                            'controller' => 'attachment',
                            'action' => 'add',
                            'sample_id' => $sample->getId(),
                            'type' => \Samples\Entity\Attachments::ATTACHMENT_TYPE_REQUEST
                ));

                //return $this->redirect()->toRoute('samples/list');
            }
        }

        return array('form' => $form, 'isPost' => $this->request->isPost());
    }

    public function editAction()
    {
        //Solo autorizzai (permissione: samples.edit)
        if (!$this->getAuthorizationService()->isGranted('samples.edit')) {
            throw new UnauthorizedException();
        }

        // Get your ObjectManager from the ServiceManager
        $objectManager = $this->getEntityManager();

        $sampleId = $this->getEvent()->getRouteMatch()->getParam('sampleId');
        $sample = $objectManager->getRepository($this->options->getSampleEntityClass())->find($sampleId);

        if (!$sample) {
            throw new \Exception('Campionatura non trovata!');
        }

        // Create the form and inject the ObjectManager
        $form = new SampleForm($objectManager);

        $fieldset = $form->remove('sample'); //fieldset

        $sampleFieldset = new \Samples\Form\Sample2Fieldset($objectManager);
        $sampleFieldset->setUseAsBaseFieldset(true);
        $form->add($sampleFieldset);



        $form->bind($sample);

        if ($this->request->isPost()) {
            $postedData = $this->request->getPost();
            $form->setData($postedData);
            if ($form->isValid()) {
                $sample->setEditDate(new \Datetime()); //setto data ultima modifica   
                $sample->setCurrentStatusDate(new \Datetime());

                //********* History *******/
                //Controllo le modifiche
                $uow = $objectManager->getUnitOfWork();
                $uow->computeChangeSets();
                $changeset = $uow->getEntityChangeSet($sample);
                $data = array(
                    'sample' => $sample,
                    'editBy' => $this->getServiceLocator()->get('zfcuser_user_mapper')
                            ->findById($this->zfcUserAuthentication()
                                    ->getIdentity()->getId()),
                    'sampleStatus' => $sample->getStatus(),
                    'editDate' => new \DateTime('NOW'),
                );
                //Cambio stato
                if (isset($changeset['status'])) {
                    //Aggiungo un record per cambio stato
                    $this->addHistory($data);

                    //Notifica via email
                    if ($sample->getStatus()->getId() == \Samples\Entity\Status::STATUS_TYPE_CANCELED) {
                        $this->sampleMapper->sendCanceledSampleEmail($sample, $this, $this->zfcUserAuthentication()->getIdentity());
                    } elseif ($sample->getStatus()->getId() == \Samples\Entity\Status::STATUS_TYPE_PROCESSED) {
                        $processed = true;
                        //nessuna notifica (spostata in processingAction)
                    }
                    //Fine Notifica via email                    
                }
                //***** Fine History *****/    


                $this->sampleMapper->update($sample);

                if (isset($processed)) {
                    return $this->redirect()->toRoute('samples/print', array('sampleId' => $sample->getId()));
                }
                $this->flashMessenger()->setNamespace('success')->addMessage('Campionatura modificata con successo');
                return $this->redirect()->toRoute('samples/edit', array('sampleId' => $sample->getId()));
            } else {
                var_dump($form->getMessages());
            }
        }

        return array(
            'form' => $form,
            'sample' => $sample,
            'attachmentPath' => $this->options->getAttachmentPath(),
        );
    }

    public function removeAction()
    {
        //Solo autorizzai (permissione: samples.remove)
        if (!$this->getAuthorizationService()->isGranted('samples.remove')) {
            throw new UnauthorizedException();
        }

        $objectManager = $this->getEntityManager();

        $sampleId = $this->getEvent()->getRouteMatch()->getParam('sampleId');
        $sample = $objectManager->getRepository($this->options->getSampleEntityClass())->find($sampleId);

        if ($sample) {
            $this->sampleMapper->remove($sample);
            $this->flashMessenger()->addSuccessMessage('La campionatura è stata eliminata!');
        }

        return $this->redirect()->toRoute('samples/update');
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
        $sampleId = $this->getEvent()->getRouteMatch()->getParam('sampleId');
        $historyType = (int) $this->getEvent()->getRouteMatch()->getParam('historyType');
        $sample = $this->getEntityManager()->getRepository($this->options->getSampleEntityClass())->find($sampleId);

        if (!$sample) {
            throw new \Exception('Campionatura non trovata!');
        }

        return array(
            'sample' => $sample,
            'historyType' => $historyType,
            'attachmentPath' => $this->options->getAttachmentPath(),
        );
    }

    //Serve a Maggini per stampare ed incollare sulla scatola
    public function printAction()
    {
        //Solo autorizzai (permissione: samples.edit)
        if (!$this->getAuthorizationService()->isGranted('samples.edit')) {
            throw new UnauthorizedException();
        }

        $sampleId = $this->getEvent()->getRouteMatch()->getParam('sampleId');
        $sample = $this->getEntityManager()->getRepository($this->options->getSampleEntityClass())->find($sampleId);

        if (!$sample) {
            throw new \Exception('Campionatura non trovata!');
        }

        return array(
            'sample' => $sample,
            'attachmentPath' => $this->options->getAttachmentPath(),
        );
    }

    /**
     * Aggiunge un record alla tabella sample_history in caso di aggiunta o 
     * modifica sample.
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

    protected function generateScheduledDeliveryDate(\Samples\Entity\Sample $sample)
    {
        $consegnaRichiesta = date('Y-m-d', $sample->getRequestedDeliveryDate()->getTimestamp());
        $qta = $sample->getQta();
        //Sistemo (non dovrebbe succedere) data consegna richiesta (non sabato o domenica)
        switch (date('w', strtotime($consegnaRichiesta))) {
            case 6: //sabato
                $consegnaRichiesta = date('Y-m-d', strtotime("+2 day", strtotime($consegnaRichiesta)));
                break;
            case 0: //domenica
                $consegnaRichiesta = date('Y-m-d', strtotime("+1 day", strtotime($consegnaRichiesta)));
                break;
            default:
                break;
        }

        /**
         * Calcolo la data consegna materiale prevista. 
         * Parto da "oggi" visto che il materiale viene richiesto subito.
         * Dato che la navetta è il venerdì, se siamo Giove o Vene si va al venerdì dopo. 
         * Altrimenti si va al venerdì prossimo. 
         */
        $today = date("Y-m-d");
        $today = date("Y-m-d", $sample->getCreatedDate()->getTimestamp());
        switch (date('w', strtotime($today))) {
            case 1://lunedì
                $add = 4;
                break;
            case 2://martedì
                $add = 3;
                break;
            case 3://mercoledì
                $add = 2;
                break;
            case 4://giovedì
                $add = 8;
                break;
            case 5://venerdì
                $add = 7;
                break;
            case 6://sabato
                $add = 6;
                break;
            case 0://domenica
                $add = 5;
                break;
            default:
                break;
        }

        $dataPrevista = date('Y-m-d', strtotime("+$add day", strtotime($today)));
        //Fine Calcolo la data consegna materiale prevista. 


        /**
         * Se la data di richiesta è successiva a quella calcolata prendo quella richiesta
         * (sistemando eventualmente sabato e domenica)
         */
        $datetime1 = new \DateTime($consegnaRichiesta);
        $datetime2 = new \DateTime($dataPrevista);
        $interval = $datetime2->diff($datetime1);
        $interval = (int) $interval->format('%R%a');
        if ($interval > 0) {
            $dataPrevista = $consegnaRichiesta;
        }

        //Quando quanti campioni sono previsti il giorno di consegna prevista
        $config = $this->getEntityManager()->getConfiguration();
        $config->addCustomStringFunction('DATE_FORMAT', 'DoctrineExtensions\Query\Mysql\DateFormat');

        $i = $this->tmp($dataPrevista, $qta);
        while ($i > 10) {
            switch (date('w', strtotime($dataPrevista))) {
                case 5://venerdì
                    $add = 3; //vado a lunedì
                    break;
                case 6://sabato
                    $add = 2; //vado a lunedì
                    break;
                default:
                    $add = 1; //aggiungo 1 gg
                    break;
            }

            $dataPrevista = date('Y-m-d', strtotime("+$add day", strtotime($dataPrevista)));
            $i = $this->tmp($dataPrevista, $qta);
            //var_dump($i);
        }//end while
        //var_dump($dataPrevista);
        return $dataPrevista;
    }

    public function tmp($date, $qta)
    {
        $query = $this->getEntityManager()->createQuery(
                "SELECT SUM(s.qta) qta FROM {$this->options->getSampleEntityClass()} s WHERE DATE_FORMAT(s.scheduledDeliveryDate, '%Y-%m-%d') = '$date'");
        //echo $query->getSql();
        $campPrev = $query->getResult()[0]['qta'];
        return (isset($campPrev)) ? ((int) $campPrev) + $qta : $qta;
    }

    public function zzDaCancellareAncheRottaAction()
    {
        //Amumento il limite tempo dello script a 300 min e memoria
        set_time_limit(18000);
        ini_set('memory_limit', '-1');

        //Leggo tabella di migrazione
        $dbAdapterConfig = array(
            'driver' => 'Mysqli',
            'database' => 'intranet',
            'username' => 'root',
            'password' => 'grimax',
                //'password' => 'ariete2014',
        );
        $dbAdapter = new Adapter($dbAdapterConfig);

        $sql = new Sql($dbAdapter);
        $select = $sql->select();
        $select->from('campionature');


        $statement = $sql->prepareStatementForSqlObject($select);
        $result = $statement->execute();

        $objectManager = $this->getEntityManager();
        $class = $this->options->getSampleEntityClass();

        $countryRepo = $objectManager->getRepository('Application\Entity\Country');
        //$user = $userMapper->findByEmail('grimani@ariete.net');
        //var_dump($user);
        //object

        /*
          $rows = $countryRepo->findAll();

          foreach ($rows as $row) {
          echo "UPDATE campionature SET paese = '{$row->getCountryId()}' WHERE paese LIKE '%{$row->getName()}%';<br/>";
          }

          return $this->getResponse();
         * 
         */


        $statusRepo = $objectManager->getRepository('Samples\Entity\Status');


        $tmp = [];
        foreach ($result as $value) {
            $v = $value['paese'];
            $country = $countryRepo->find((int) $v);
            if (!isset($country)) {
                $tmp[$v] = isset($tmp[$v]) ? $tmp[$v] + 1 : 1;
            }
        }
        var_dump($tmp);


        return $this->getResponse();
    }

    public function migrationAction()
    {

        //bloccato
        return $this->getResponse();

        //senza parametro parte subito da 0 (prima riga)
        $start = $this->params()->fromQuery('start', 0);
        $incrementa = 200;
        $urlViewHelper = $this->getServiceLocator()->get('ViewHelperManager')->get('url');
        $newStart = $start + $incrementa;
        echo '<p><a href="' . $urlViewHelper('samples/migration', [], ['query' => ['start' => $newStart]]) . '">Lancia Migrazione (parti da ' . $newStart . ')</a></p>';



        //Amumento il limite tempo dello script a 300 min e memoria
        set_time_limit(18000);
        ini_set('memory_limit', '-1');

        //Leggo tabella di migrazione
        $dbAdapterConfig = array(
            'driver' => 'Mysqli',
            'database' => 'intranet',
            'username' => 'root',
            //'password' => 'grimax',
            'password' => 'ariete2014',
        );
        $dbAdapter = new Adapter($dbAdapterConfig);

        $sql = new Sql($dbAdapter);
        $select = $sql->select();
        $select->from('campionature')->limit($incrementa)->offset($start);
        //$select->where(array('myColumn' => 5));
        //echo $select->getSqlString();
        //return $this->getResponse();

        $statement = $sql->prepareStatementForSqlObject($select);
        $result = $statement->execute();

        $objectManager = $this->getEntityManager();
        $class = $this->options->getSampleEntityClass();

        $userMapper = $this->getServiceLocator()->get('zfcuser_user_mapper');
        //$user = $userMapper->findByEmail('grimani@ariete.net');
        //var_dump($user);

        $notFound = [];
        $allegatiRichiesta = [];
        $allegatiEvasione = [];

        //Scorciatoie
        $statusArray = [];
        $usersArray = [];
        $countryArray = [];


        //object
        $countryRepo = $objectManager->getRepository('Application\Entity\Country');
        $statusRepo = $objectManager->getRepository('Samples\Entity\Status');

        //default
        $defaultApplicant = $userMapper->findByEmail('anonymous@ariete.net');
        $defaultEditor = $userMapper->findByEmail('gianni.maggini@ariete.net');
        $defaultShipper = $userMapper->findByEmail('riccardo.peschi@ariete.net');
        $defaultCountry = $countryRepo->find(105);

        foreach ($result as $value) {
            $createdDate = new \DateTime($value['data']);


            $sample = new $class();
            $sample->setCustomer(utf8_encode($value['cliente']));
            $sample->setModel(utf8_encode($value['modello']));

            $sample->setQta($value['quantita']);
            $sample->setQtaExpected($value['quantitaprevista']);
            $sample->setPaymentTerm(utf8_encode($value['terminedipagamento']));
            $sample->setVpp(utf8_encode($value['vpp']));
            $sample->setVoltage(utf8_encode($value['tensione']));
            $sample->setFrequency(utf8_encode($value['frequenza']));
            $sample->setPlug(utf8_encode($value['spina']));
            $sample->setCable(utf8_encode($value['cavo']));
            $sample->setSerigraphy(utf8_encode($value['serigrafia']));
            $sample->setColors(utf8_encode($value['colori']));
            $sample->setAccessories(utf8_encode($value['accessori']));
            $sample->setBooklet(utf8_encode($value['libretto']));
            $sample->setPackaging(utf8_encode($value['imballo']));
            $sample->setNote(utf8_encode($value['note']));

            $tmp = ($value['xlami']) ? 1 : 0;
            $sample->setPainting($tmp);
            $sample->setToBeSerigraphy(0);
            $tmp = ($value['prodottostandard'] == 'si') ? 1 : 0;
            $sample->setStandardProduct($tmp);
            $tmp = ($value['campioneperapprovazione'] == 'si') ? 1 : 0;
            $sample->setApprovalSample($tmp);


            $sample->setVoltageProvided(utf8_encode($value['tensioneevasa']));
            $sample->setFrequencyProvided(utf8_encode($value['frequenzaevasa']));
            $sample->setPlugProvided(utf8_encode($value['spinaevasa']));
            $sample->setCableProvided(utf8_encode($value['cavoevaso']));
            $sample->setSerigraphyProvided(utf8_encode($value['serigrafiaevasa']));
            $sample->setColorsProvided(utf8_encode($value['coloreevaso']));
            $sample->setAccessoriesProvided(utf8_encode($value['accessorievasi']));
            $sample->setBookletProvided(utf8_encode($value['librettoevaso']));
            $sample->setPackagingProvided(utf8_encode($value['imballoevaso']));
            $sample->setEdtProvided(utf8_encode($value['edtevaso']));
            $sample->setAbsorptionProvided(utf8_encode($value['assorbimentoevaso']));
            $sample->setSfasamentoProvided(utf8_encode($value['cosevaso']));
            $sample->setPressureProvided(utf8_encode($value['pressioneevasa']));
            $sample->setNoteProvided(utf8_encode($value['altroevaso']));
            $sample->setEmail1(0);
            $sample->setEmail2(0);

            $sample->setCreatedDate($createdDate);
            $sample->setEditDate($createdDate);
            $sample->setRequestedDeliveryDate(new \DateTime($value['dataconsegnarichiesta']));

            $tmp = (!empty($value['dataconsegnaprevista'])) ? $value['dataconsegnaprevista'] : $value['dataconsegnarichiesta'];
            $sample->setScheduledDeliveryDate(new \DateTime($tmp));

            //Richiedente
            $key = $value['richiedente'];
            if (!isset($usersArray[$key])) {
                $usersArray[$key] = $userMapper->findByEmail($key);
            }
            $applicant = $usersArray[$key];

            if (!isset($applicant)) {
                $applicant = $defaultApplicant;
            }
            $sample->setApplicant($applicant);
            // Fine Richiedente
            //Country
            $key = $value['paese'];
            if (!isset($countryArray[$key])) {
                $countryArray[$key] = $countryRepo->find((int) $key);
            }
            $country = $countryArray[$key];

            if (!isset($country)) {
                $country = $defaultCountry;
            }
            $sample->setCountry($country);
            // Fine Country   
            //Allegati
            for ($i = 1; $i <= 12; $i++) {
                $tmp = $value['allegatorichiesta' . $i];
                if ((!empty($tmp)) && ($tmp != '-')) {
                    //$allegatiRichiesta[] = basename($tmp);
                    $data = [
                        'sample' => $sample,
                        'fileName' => basename($tmp),
                        'attachmentType' => 'richiesta',
                    ];
                    $this->addAttachment($data);
                }
            }
            for ($i = 1; $i <= 12; $i++) {
                $tmp = $value['allegatoevaso' . $i];
                if ((!empty($tmp)) && ($tmp != '-')) {
                    //$allegatiEvasione[] = basename($tmp);
                    $data = [
                        'sample' => $sample,
                        'fileName' => basename($tmp),
                        'attachmentType' => 'evasione',
                    ];
                    $this->addAttachment($data);
                }
            }
            //Fine Allegati
            //Editor
            $key = $value['compilatoda'];
            if (!isset($usersArray[$key])) {
                $usersArray[$key] = $userMapper->findByEmail($key);
            }
            $editor = $usersArray[$key];

            if (!isset($editor)) {
                $editor = $defaultEditor;
            }
            // Editor     
            //History
            //1)
            $key = \Samples\Entity\Status::STATUS_TYPE_PENDING_EVASION;
            if (!isset($statusArray[$key])) {
                $statusArray[$key] = $statusRepo->find($key);
            }
            $status = $statusArray[$key];
            $data = array(
                'sample' => $sample,
                'editBy' => $applicant,
                'sampleStatus' => $status,
                'editDate' => $createdDate,
            );
            $this->addHistory($data);

            //5
            if ($value['prodrichiesti']) {
                $key = \Samples\Entity\Status::STATUS_TYPE_PRODUCT_REQUIRED;
                if (!isset($statusArray[$key])) {
                    $statusArray[$key] = $statusRepo->find($key);
                }
                $status = $statusArray[$key];
                $data = array(
                    'sample' => $sample,
                    'editBy' => $editor,
                    'sampleStatus' => $status,
                    'editDate' => $createdDate,
                );
                $this->addHistory($data);
            }

            //10
            if ($value['prodarrivati']) {
                $key = \Samples\Entity\Status::STATUS_TYPE_PRODUCT_ARRIVED;
                if (!isset($statusArray[$key])) {
                    $statusArray[$key] = $statusRepo->find($key);
                }
                $status = $statusArray[$key];
                $data = array(
                    'sample' => $sample,
                    'editBy' => $editor,
                    'sampleStatus' => $status,
                    'editDate' => $createdDate,
                );
                $this->addHistory($data);
            }

            //15
            if ($value['evasa']) {
                $key = \Samples\Entity\Status::STATUS_TYPE_PROCESSED;
                if (!isset($statusArray[$key])) {
                    $statusArray[$key] = $statusRepo->find($key);
                }
                $status = $statusArray[$key];
                if (!empty($value['dataevasione'])) {
                    $processingDate = new \DateTime($value['dataevasione']);
                } else {
                    $processingDate = $createdDate;
                }
                $data = array(
                    'sample' => $sample,
                    'editBy' => $editor,
                    'sampleStatus' => $status,
                    'editDate' => $processingDate,
                );
                $this->addHistory($data);
            }

            //20
            if (!empty($value['dataspediz'])) {
                $key = \Samples\Entity\Status::STATUS_TYPE_SHIPPED;
                if (!isset($statusArray[$key])) {
                    $statusArray[$key] = $statusRepo->find($key);
                }
                $status = $statusArray[$key];
                $data = array(
                    'sample' => $sample,
                    'editBy' => $defaultShipper,
                    'sampleStatus' => $status,
                    'editDate' => new \DateTime($value['dataspediz']),
                );
                $this->addHistory($data);
            }

            //25
            if ($value['annullata']) {
                $key = \Samples\Entity\Status::STATUS_TYPE_CANCELED;
                if (!isset($statusArray[$key])) {
                    $statusArray[$key] = $statusRepo->find($key);
                }
                $status = $statusArray[$key];
                $data = array(
                    'sample' => $sample,
                    'editBy' => $editor,
                    'sampleStatus' => $status,
                    'editDate' => $createdDate,
                );
                $this->addHistory($data);
            }

            //Data stato corrente
            if (!empty($value['dataspediz'])) {
                $sample->setEmail1(1);
                $sample->setCurrentStatusDate(new \DateTime($value['dataspediz']));
            } elseif (!empty($value['dataevasione'])) {
                $sample->setCurrentStatusDate(new \DateTime($value['dataevasione']));
            } else {
                $sample->setCurrentStatusDate(new \DateTime($value['data']));
            }

            //Fine History
            //var_dump($sample);
            $sample->setStatus($status);
            $this->sampleMapper->insert($sample);

            //echo $sample->getId() . ' --> ' . $value['id'] . '<br/>';
        }

        echo '<h1>Finito!</h1>';





        return $this->getResponse();
    }

    /**
     * Aggiunge un record alla tabella sample_attachment. (usato per migrazione)
     * 
     * @param array $data
     */
    protected function addAttachment($data)
    {
        $attachmentsClass = $this->options->getAttachmentsEntityClass();
        $attachment = new $attachmentsClass();
        $hydrator = new DoctrineHydrator($this->getEntityManager(), $attachmentsClass);
        $attachment = $hydrator->hydrate($data, $attachment);

        //var_dump($attachment);
        $this->getServiceLocator()->get('Samples\Mapper\AttachmentsMapper')->insert($attachment);
    }


}
