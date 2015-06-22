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
use DoctrineExtensions\Query\Mysql\Year;
//Form
use Samples\Form\SampleForm;
use Application\Form\SearchForm;
//ZfcRbac
use ZfcRbac\Exception\UnauthorizedException;

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
        $queryPieBrand = $this->getEntityManager()->createQuery('SELECT COUNT(c.id) nr, b.name FROM Computer\Entity\Computer c JOIN c.brand b GROUP BY c.brand');
        $queryPieCategory = $this->getEntityManager()->createQuery('SELECT COUNT(c.id) nr, t.name FROM Computer\Entity\Computer c JOIN c.category t GROUP BY c.category');

        $paginator = new Paginator\Paginator(
                new DoctrinePaginator(new ORMPaginator($this->sampleMapper->getSearchQuery('', 's.id', 'DESC')))
        );

        $paginator->setItemCountPerPage(20);
        $paginator->setCurrentPageNumber(1);

        $processedStatus = [
            \Samples\Entity\Status::STATUS_TYPE_PROCESSED,
            \Samples\Entity\Status::STATUS_TYPE_SHIPPED
        ];


        $config = $this->getEntityManager()->getConfiguration();
        $config->addCustomStringFunction('YEAR', 'DoctrineExtensions\Query\Mysql\Year');

        $queryProcessedCount = $this->getEntityManager()->createQuery('SELECT COUNT(s.id) nr FROM Samples\Entity\Sample s WHERE s.status IN (' . implode(',', $processedStatus) . ')');
        $queryPendingCount = $this->getEntityManager()->createQuery('SELECT COUNT(s.id) nr FROM Samples\Entity\Sample s WHERE s.status < ' . \Samples\Entity\Status::STATUS_TYPE_PROCESSED);
        $queryCancelCount = $this->getEntityManager()->createQuery('SELECT COUNT(s.id) nr FROM Samples\Entity\Sample s WHERE s.status = ' . \Samples\Entity\Status::STATUS_TYPE_CANCELED);
        $queryPieCount = $this->getEntityManager()->createQuery('SELECT COUNT(s.id) nr, YEAR(s.createdDate) y FROM Samples\Entity\Sample s GROUP BY y');

        var_dump($queryPieCount->getResult());
        var_dump($this->generateScheduledDeliveryDate());
        return array(
            'sampleCount' => $this->sampleMapper->count(),
            'processedCount' => $queryProcessedCount->getResult()[0]['nr'],
            'pendingCount' => $queryPendingCount->getResult()[0]['nr'],
            'cancelCount' => $queryCancelCount->getResult()[0]['nr'],
            'chartPieBrand' => $queryPieBrand->getResult(),
            'chartPieCategory' => $queryPieCategory->getResult(),
            'samples' => $paginator,
        );
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


                //***** History
                $data = array(
                    'sample' => $sample,
                    'editBy' => $this->getServiceLocator()->get('zfcuser_user_mapper')
                            ->findById($this->zfcUserAuthentication()
                                    ->getIdentity()->getId()),
                    'sampleStatus' => $sample->getStatus(),
                );

                //Aggiungo un record per nuova richiesta
                $this->addHistory($data);
                //***** Fine History           

                $this->sampleMapper->insert($sample);

                return $this->redirect()->toRoute('samples/attachments/add', array(
                            'controller' => 'attachment',
                            'action' => 'add',
                            'sample_id' => $sample->getId(),
                            'type' => \Samples\Entity\Attachments::ATTACHMENT_TYPE_REQUEST
                ));

                //return $this->redirect()->toRoute('samples/list');
            }
        }

        return array('form' => $form);
    }

    public function editAction()
    {
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
                );
                //Cambio stato
                if (isset($changeset['status'])) {
                    //Aggiungo un record per cambio stato
                    $this->addHistory($data);
                }
                //***** Fine History *****/    


                $this->sampleMapper->update($sample);

                $this->flashMessenger()->setNamespace('success')->addMessage('Campionatura modificata con successo');
                return $this->redirect()->toRoute('samples/show', array('sampleId' => $sample->getId()));
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
        //Solo superuser
        if (!$this->getAuthorizationService()->isGranted('computer.superuser')) {
            //throw new UnauthorizedException();
        }

        $objectManager = $this->getEntityManager();

        $sampleId = $this->getEvent()->getRouteMatch()->getParam('sampleId');
        $sample = $objectManager->getRepository($this->options->getSampleEntityClass())->find($sampleId);

        if ($sample) {
            $this->sampleMapper->remove($sample);
            $this->flashMessenger()->addSuccessMessage('La campionatura è stata eliminata!');
        }

        return $this->redirect()->toRoute('samples/list');
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
        return array(
            'sample' => $this->getEntityManager()->getRepository($this->options->getSampleEntityClass())->find($sampleId),
            'historyType' => $historyType,
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

    protected function generateScheduledDeliveryDate()
    {
        $consegnaRichiesta = date('Y-m-d', strtotime('2015-06-27')); //da cambiare con data richiesta
        $qta = 5; //da cambiare con quantita della richiesta
        
        //Sistemo eventualemte data consegna richiesta (non sabato o domenica)
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
        
    
        
    
        $today = date('Y-m-d');
        // add 3 days to date
        $newDate = Date('Y-m-d', strtotime("+3 days"));
        echo $newDate;


        /**
         * Calcolo la data consegna materiale prevista. Dato che la navetta è il
         * venerdì, se siamo Giove o Vene si va al venerdì dopo. 
         * Altrimenti si va al venerdì prossimo. 
         */
        $weekDay = date('w', strtotime($today));
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
        var_dump($dataPrevista);
        
        
        
        //Quanrdo quanti campioni sono previsti il giorno di consegna prevista
        $config = $this->getEntityManager()->getConfiguration();
        $config->addCustomStringFunction('DATE_FORMAT', 'DoctrineExtensions\Query\Mysql\DateFormat');
        $query = $this->getEntityManager()->createQuery("SELECT SUM(s.qta) qta FROM Samples\Entity\Sample s WHERE DATE_FORMAT(s.scheduledDeliveryDate, '%Y-%m-%d') = '$dataPrevista'");
        echo $query->getSql();
        $campPrev = $query->getResult()[0]['qta'];
        $campPrev = isset($campPrev) ? ((int) $campPrev) + $qta : $qta;
        var_dump($campPrev);
        
        
    }

}
