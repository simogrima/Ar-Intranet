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
use ZfcUserDoctrineORM\Mapper\User as ZfcUserDoctrineMapper;

use Computer\Entity\History;

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
    protected $computerMapper;

    /**
     *
     * @var type Computer\Mapper\HistoryMapper
     */
    protected $historyMapper;

    public function __construct($options, $mapper, $mapperHistory)
    {
        $this->options = $options;
        $this->computerMapper = $mapper;
        $this->historyMapper = $mapperHistory;
    }

    public function indexAction()
    {
        return array(
            'computerCount' => count($this->computerMapper->findAll()),
        );
    }

    public function listAction()
    {
        $computers = $this->computerMapper->findAll();
        if (is_array($computers)) {
            $paginator = new Paginator\Paginator(new Paginator\Adapter\ArrayAdapter($computers));
        } else {
            $paginator = $computers;
        }

        $paginator->setItemCountPerPage(30);
        $paginator->setCurrentPageNumber($this->getEvent()->getRouteMatch()->getParam('page'));
        return array(
            'computers' => $paginator,
            //'computerlistElements' => $this->options->getRoleListElements(),
            'pageAction' => 'computer/list',
        );
    }

    public function createAction()
    {
        $objectManager = $this->getEntityManager();

        // Create the form and inject the ObjectManager
        $form = new ComputerForm($objectManager);

        // Create a new, empty entity and bind it to the form
        $class = $this->options->getComputerEntityClass();
        $computer = new $class();
        $form->bind($computer);

        if ($this->request->isPost()) {
            $form->setData($this->request->getPost());
            if ($form->isValid()) {

                /*** * History *** */
                //Dati di default
                $data = array(
                    'computer' => $computer,
                    'recipient' => $this->getServiceLocator()->get('zfcuser_user_mapper')
                            ->findById($computer->getRecipient()->getId()),
                    'editBy' => $this->getServiceLocator()->get('zfcuser_user_mapper')
                            ->findById($this->zfcUserAuthentication()
                                    ->getIdentity()->getId()),
                    'computerStatus' => $computer->getStatus(),
                    'type' => History::HISTORY_TYPE_COMPUTER_CREATE,
                );
                
                //Aggiungo un record per cambio stato
                $this->addHistory($data);     
                
                //Aggiungo un record per assegnazione
                $data['type'] = History::HISTORY_TYPE_COMPUTER_CHAGE_RECIPIENT;
                $this->addHistory($data);                
                /*** *  Fine History *** */                
                
                $this->computerMapper->insert($computer);

                $this->flashMessenger()->setNamespace('success')->addMessage('Computer added successfully');
                return $this->redirect()->toRoute('computer/list');
            }
        }

        return array('form' => $form);
    }

    public function editAction()
    {
        $objectManager = $this->getEntityManager();

        $computerId = $this->getEvent()->getRouteMatch()->getParam('computerId');
        $computer = $objectManager->getRepository($this->options->getComputerEntityClass())->find($computerId);
        
        if (!$computer) {
            throw new \Exception('Computer not found');
        }

        // Create the form and inject the ObjectManager
        $form = new ComputerForm($objectManager);
        $form->bind($computer);

        if ($this->request->isPost()) {
            $postedData = $this->request->getPost();
            $form->setData($postedData);
            if ($form->isValid()) {

                /*** * History *** */
                //Controllo le modifiche
                $uow = $objectManager->getUnitOfWork();
                $uow->computeChangeSets();
                $changeset = $uow->getEntityChangeSet($computer);

                //Dati di default
                $data = array(
                    'computer' => $computer,
                    'recipient' => $this->getServiceLocator()->get('zfcuser_user_mapper')
                            ->findById($computer->getRecipient()->getId()),
                    'editBy' => $this->getServiceLocator()->get('zfcuser_user_mapper')
                            ->findById($this->zfcUserAuthentication()
                                    ->getIdentity()->getId()),
                    'computerStatus' => $computer->getStatus(),
                );

                $noModify = false;
                $noRecipient = false;

                //Cambio stato
                if (isset($changeset['status'])) {
                    $data['type'] = History::HISTORY_TYPE_COMPUTER_CHAGE_STATUS;
                    $noModify = true;
                    //Aggiungo un record per cambio stato
                    $this->addHistory($data);
                    
                    /**
                     * Se è passato in stato scorta
                     * 1) assegno computer ad utente scortaUserId (ced) 
                     * 2) aggiungo record anche per cambio destinatario
                     */
                    if ($computer->getStatus()->getId() == $this->options->getScortaId()) {
                        $computer->setRecipient($this->getServiceLocator()->get('zfcuser_user_mapper')
                            ->findById($this->options->getScortaUserId()));
                        $data['type'] = History::HISTORY_TYPE_COMPUTER_CHAGE_RECIPIENT;
                        $data['recipient'] = $computer->getRecipient();
                        $noRecipient = true;
                        $this->addHistory($data);
                    }
                }
                
                //Cambio destinatario 
                if($noRecipient == FALSE && isset($changeset['recipient'])) {
                    $noModify = true;
                    $data['type'] = History::HISTORY_TYPE_COMPUTER_CHAGE_RECIPIENT;
                    $this->addHistory($data);                    
                }
                
                //Modifica generica
                if ($noModify == false) {
                    $data['type'] = History::HISTORY_TYPE_COMPUTER_MODIFY;
                    $this->addHistory($data);
                }
                /*** *  Fine History *** */
                
                
                $computer->setEditdDate(new \Datetime()); //setto data ultima modifica
                $this->computerMapper->update($computer);
                
                $this->flashMessenger()->setNamespace('success')->addMessage('Computer edit successfully');
                return $this->redirect()->toRoute(
                        'computer/show', 
                        array(
                            'computerId' => $computer->getId(),
                            'historyType' => 0,
                        ));
            }
        }

        return array('form' => $form);
    }

    public function removeAction()
    {
        $objectManager = $this->getEntityManager();

        $computerId = $this->getEvent()->getRouteMatch()->getParam('computerId');
        $computer = $objectManager->getRepository($this->options->getComputerEntityClass())->find($computerId);

        if ($computer) {
            $this->computerMapper->remove($computer);
            $this->flashMessenger()->addSuccessMessage('The computer was deleted');
        }

        return $this->redirect()->toRoute('computer/list');
    }

    public function showAction()
    {
        $computerId = $this->getEvent()->getRouteMatch()->getParam('computerId');
        $historyType = (int) $this->getEvent()->getRouteMatch()->getParam('historyType');
        return array(
            'computer' => $this->getEntityManager()->getRepository($this->options->getComputerEntityClass())->find($computerId),
            'historyType' => $historyType,
        );
    }

    public function settingsAction()
    {
        $categoryMapper = $this->getServiceLocator()->get('Computer\Mapper\CategoryMapper');
        $brandMapper = $this->getServiceLocator()->get('Computer\Mapper\BrandMapper');
        $processorMapper = $this->getServiceLocator()->get('Computer\Mapper\ProcessorMapper');

        return array(
            'categories' => $categoryMapper->findAll(),
            'brands' => $brandMapper->findAll(),
            'processors' => $processorMapper->findAll(),
        );
    }

    /**
     * Aggiunge un record alla tabella computer_history in caso di aggiunta o 
     * modifica computer.
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
    
    public function clearHistoryAction()
    {
        $computerId = $this->getEvent()->getRouteMatch()->getParam('computerId');
        $computer = $this->getEntityManager()->getRepository($this->options->getComputerEntityClass())->find($computerId);
        
        if ($computer) {
            $computer->removeHistory($computer->getHistory());
            $this->flashMessenger()->setNamespace('success')->addMessage('Computer history clear successfully');
            $this->getEntityManager()->persist($computer);
            $this->getEntityManager()->flush();
            return $this->redirect()->toRoute(
                    'computer/show', 
                    array(
                        'computerId' => $computer->getId(),
                        'historyType' => 0,
                    ));            
        }
        //To disable the view completely, from within a controller action, you should return a Response object
        $response = $this->getResponse();
        return $response;        
    }     
    
    public function userHistoryAction()
    {
        $userId = $this->getEvent()->getRouteMatch()->getParam('userId');
        $user = $this->getServiceLocator()->get('zfcuser_user_mapper')->findById((int) $userId);
        if ($user) {
            $history = $this->getEntityManager()
                         ->getRepository($this->options->getHistoryEntityClass())
                         ->findBy(array('recipient' => $user, 'type' => History::HISTORY_TYPE_COMPUTER_CHAGE_RECIPIENT));
            return array(
                'title' => 'Storico Computer di ' .  $user->getDisplayName(),
                'history' => $history,
            );            
        }
        
        $response = $this->getResponse();
        return $response;          
    }        

}
