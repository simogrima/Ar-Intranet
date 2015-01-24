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
use Doctrine\ORM\Tools\Pagination\Paginator as ORMPaginator;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator;
//Form
use Computer\Form\HistoryForm;

//ZfcRbac
use ZfcRbac\Exception\UnauthorizedException;

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
        $paginator = new Paginator\Paginator(
            new DoctrinePaginator(new ORMPaginator($this->historyMapper->getSearchQuery()))
        );

        $paginator->setItemCountPerPage(30);
        $paginator->setCurrentPageNumber($this->getEvent()->getRouteMatch()->getParam('page'));
        return array(
            'history' => $paginator,
            'pageAction' => 'computer/history/list',
        );
    }    
     
    public function editAction()
    {
        //Solo superuser
        if (!$this->getAuthorizationService()->isGranted('computer.superuser')) {
           throw new UnauthorizedException();
        }        
        
        // Get your ObjectManager from the ServiceManager
        $objectManager = $this->getEntityManager();

        $historyId = $this->getEvent()->getRouteMatch()->getParam('historyId');
        $history = $objectManager->getRepository($this->options->getHistoryEntityClass())->find($historyId);

        // Create the form and inject the ObjectManager
        $form = new HistoryForm($objectManager);
        $form->bind($history);
        $form->get('edit_by')->setValue($this->zfcUserAuthentication()->getIdentity()->getId());
        $form->get('computer_id')->setValue($history->getComputer()->getId());
        
      

        if ($this->request->isPost()) {
            $postedData = $this->request->getPost();
            $form->setData($postedData);
            $redirectUrl = $form->get('redirect')->getValue(); //x redirect
            if ($form->isValid()) {
                
                $this->historyMapper->update($history);

                $this->flashMessenger()->setNamespace('success')->addMessage('History edit successfully');

                //redirect in base da dove provengo
                if (!empty($redirectUrl)) {
                    return $this->redirect()->toUrl($redirectUrl);
                }
                
                return $this->redirect()->toRoute('computer/history');
                
            } else {
                var_dump($form->getValidationGroup());    
            }
        }
        
        //se provengo da scheda computer redirect lì.
        $redirectUrl = $url = $this->getRequest()->getHeader('Referer')->getUri();
        if (strpos($redirectUrl,'computer/show') !== false) {
            $form->get('redirect')->setValue($redirectUrl);
        }          

        return array('form' => $form, 'computer' => $history->getComputer());
    }
    
    public function removeAction()
    {
        //Solo superuser
        if (!$this->getAuthorizationService()->isGranted('computer.superuser')) {
           throw new UnauthorizedException();
        }
        
        $historyId = $this->getEvent()->getRouteMatch()->getParam('historyId');
        $history = $this->getEntityManager()->getRepository($this->options->getHistoryEntityClass())->find($historyId);

        if ($history) {
            $this->historyMapper->remove($history);
            $this->flashMessenger()->addSuccessMessage('The history was deleted');
        }
        
        //se provengo da scheda computer redirect lì.
        $redirectUrl = $url = $this->getRequest()->getHeader('Referer')->getUri();
        if (strpos($redirectUrl,'computer/show') !== false) {
            return $this->redirect()->toUrl($redirectUrl);
        }             

        return $this->redirect()->toRoute('computer/history');
    }    

}
