<?php

/**
 * Prototyping\Controller\History
 *
 * @author Simone Grimani
 * @copyright  Copyright (c) 2014 Simone Grimani (http://www.simogrima.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

namespace Prototyping\Controller;

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
use Prototyping\Form\HistoryForm;
//ZfcRbac
use ZfcRbac\Exception\UnauthorizedException;

class HistoryController extends EntityUsingController
{

    /**
     * @var Prototyping\Options\ModuleOptions
     */
    protected $options;

    /**
     *
     * @var type Prototyping\Mapper\HistoryMapper
     */
    protected $historyMapper;

    public function __construct($options, $mapper)
    {
        $this->options = $options;
        $this->historyMapper = $mapper;
    }

    public function editAction()
    {
        //Solo autorizzai (permissione: prototyping.edit)
        if (!$this->getAuthorizationService()->isGranted('prototyping.edit')) {
            throw new UnauthorizedException();
        }

        // Get your ObjectManager from the ServiceManager
        $objectManager = $this->getEntityManager();

        $historyId = $this->getEvent()->getRouteMatch()->getParam('historyId');
        $history = $objectManager->getRepository($this->options->getHistoryEntityClass())->find($historyId);

        // Create the form and inject the ObjectManager
        $form = new HistoryForm($objectManager);
        $form->bind($history);
        $form->get('editBy')->setValue($this->zfcUserAuthentication()->getIdentity()->getId());
        $form->get('prototyping')->setValue($history->getPrototyping()->getId());



        if ($this->request->isPost()) {
            $postedData = $this->request->getPost();
            $form->setData($postedData);
            if ($form->isValid()) {
                
                if ($history->getPrototypingStatus()->getId() == \Prototyping\Entity\Status::STATUS_TYPE_CLOSED) {
                    $prototyping = $history->getPrototyping();
                    $prototyping->setEndDate($history->getEditDate());
                    $prototypingMapper = $this->getServiceLocator()->get('Prototyping\Mapper\PrototypingMapper');
                    $prototypingMapper->update($prototyping);
                }
                


                
                
                $this->historyMapper->update($history);
                $this->flashMessenger()->setNamespace('success')->addMessage('Storico modificato con successo');

                return $this->redirect()->toRoute('prototyping/edit', array('prototypingId' => $history->getPrototyping()->getId()));
            } else {
                var_dump($form->getValidationGroup());
            }
        }


        return array('form' => $form, 'prototyping' => $history->getPrototyping());
    }

    public function removeAction()
    {
        //Solo autorizzai (permissione: prototyping.edit)
        if (!$this->getAuthorizationService()->isGranted('prototyping.edit')) {
            throw new UnauthorizedException();
        }

        $historyId = $this->getEvent()->getRouteMatch()->getParam('historyId');
        $history = $this->getEntityManager()->getRepository($this->options->getHistoryEntityClass())->find($historyId);

        if ($history) {
            $this->historyMapper->remove($history);
            $this->flashMessenger()->addSuccessMessage('Lo storico è stato eliminato');
        }

        //se provengo da scheda computer redirect lì.
        $redirectUrl = $url = $this->getRequest()->getHeader('Referer')->getUri();
        if (strpos($redirectUrl, 'prototyping/edit') !== false) {
            return $this->redirect()->toUrl($redirectUrl);
        }

        return $this->redirect()->toRoute('prototyping/history');
    }


}
