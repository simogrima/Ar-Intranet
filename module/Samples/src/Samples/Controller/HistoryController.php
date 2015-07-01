<?php

/**
 * Samples\Controller\History
 *
 * @author Simone Grimani
 * @copyright  Copyright (c) 2014 Simone Grimani (http://www.simogrima.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

namespace Samples\Controller;

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
use Samples\Form\HistoryForm;
//ZfcRbac
use ZfcRbac\Exception\UnauthorizedException;

class HistoryController extends EntityUsingController
{

    /**
     * @var Samples\Options\ModuleOptions
     */
    protected $options;

    /**
     *
     * @var type Samples\Mapper\HistoryMapper
     */
    protected $historyMapper;

    public function __construct($options, $mapper)
    {
        $this->options = $options;
        $this->historyMapper = $mapper;
    }

    public function editAction()
    {
        //Solo superuser
        if (!$this->getAuthorizationService()->isGranted('computer.superuser')) {
            //throw new UnauthorizedException();
        }

        // Get your ObjectManager from the ServiceManager
        $objectManager = $this->getEntityManager();

        $historyId = $this->getEvent()->getRouteMatch()->getParam('historyId');
        $history = $objectManager->getRepository($this->options->getHistoryEntityClass())->find($historyId);

        // Create the form and inject the ObjectManager
        $form = new HistoryForm($objectManager);
        $form->bind($history);
        $form->get('editBy')->setValue($this->zfcUserAuthentication()->getIdentity()->getId());
        $form->get('sample')->setValue($history->getSample()->getId());



        if ($this->request->isPost()) {
            $postedData = $this->request->getPost();
            $form->setData($postedData);
            if ($form->isValid()) {
                $this->historyMapper->update($history);
                $this->flashMessenger()->setNamespace('success')->addMessage('Storico modificato con successo');

                return $this->redirect()->toRoute('samples/edit', array('sampleId' => $history->getSample()->getId()));
            } else {
                var_dump($form->getValidationGroup());
            }
        }


        return array('form' => $form, 'sample' => $history->getSample());
    }

    public function removeAction()
    {
        //Solo superuser
        if (!$this->getAuthorizationService()->isGranted('computer.superuser')) {
            //throw new UnauthorizedException();
        }

        $historyId = $this->getEvent()->getRouteMatch()->getParam('historyId');
        $history = $this->getEntityManager()->getRepository($this->options->getHistoryEntityClass())->find($historyId);

        if ($history) {
            $this->historyMapper->remove($history);
            $this->flashMessenger()->addSuccessMessage('Lo storico è stato eliminato');
        }

        //se provengo da scheda computer redirect lì.
        $redirectUrl = $url = $this->getRequest()->getHeader('Referer')->getUri();
        if (strpos($redirectUrl, 'samples/edit') !== false) {
            return $this->redirect()->toUrl($redirectUrl);
        }

        return $this->redirect()->toRoute('samples/history');
    }

    public function shippingAction()
    {
        //Solo superuser
        if (!$this->getAuthorizationService()->isGranted('computer.superuser')) {
            //throw new UnauthorizedException();
        }

        $sampleId = $this->getEvent()->getRouteMatch()->getParam('sampleId');
        $sample = $this->getEntityManager()->getRepository($this->options->getSampleEntityClass())->find($sampleId);

        if (!$sample) {
            throw new \Exception('Campionatura non trovata!');
        }

        if ($sample->isShipped()) {
            throw new \Exception('La campionatura è già spedita!');
        }

        // Get your ObjectManager from the ServiceManager
        $objectManager = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');

        // Create the form and inject the ObjectManager
        $form = new HistoryForm($objectManager);

        // Create a new, empty entity and bind it to the form
        $class = $this->options->getHistoryEntityClass();
        $history = new $class();
        $form->bind($history);
        $form->get('editBy')->setValue($this->zfcUserAuthentication()->getIdentity()->getId());
        $form->get('sampleStatus')->setValue(\Samples\Entity\Status::STATUS_TYPE_SHIPPED);
        $form->get('sample')->setValue($sample->getId());

        if ($this->request->isPost()) {
            $postedData = $this->request->getPost();
            $form->setData($postedData);
            if ($form->isValid()) {

                $this->historyMapper->insert($history);

                //setto anche campionatura
                $sampeMapper = $objectManager = $this->getServiceLocator()->get('Samples\Mapper\SampleMapper');
                $sample->setStatus($history->getSampleStatus());
                $sampeMapper->update($sample);

                $this->flashMessenger()->setNamespace('success')->addMessage('Campionatura spedita!');
                return $this->redirect()->toRoute('samples/ship');
            }
        }

        return array('form' => $form, 'sample' => $sample, 'isAjax' => $this->request->isXmlHttpRequest());
    }

}
