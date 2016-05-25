<?php

/**
 * Proto\Controller\History
 *
 * @author Simone Grimani
 * @copyright  Copyright (c) 2014 Simone Grimani (http://www.simogrima.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

namespace Proto\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Application\Controller\EntityUsingController;
use Zend\Paginator;
use Zend\Stdlib\Hydrator\ClassMethods;
//Doctrine
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Doctrine\ORM\Tools\Pagination\Paginator as ORMPaginator;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator;
//Form
use Proto\Form\HistoryForm;
//ZfcRbac
use ZfcRbac\Exception\UnauthorizedException;

class HistoryController extends EntityUsingController
{

    /**
     * @var Proto\Options\ModuleOptions
     */
    protected $options;

    /**
     *
     * @var type Proto\Mapper\HistoryMapper
     */
    protected $historyMapper;

    public function __construct($options, $mapper)
    {
        $this->options = $options;
        $this->historyMapper = $mapper;
    }

    public function editAction()
    {
        //Solo autorizzai (permissione: proto.edit)
        if (!$this->getAuthorizationService()->isGranted('proto.edit')) {
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
        $form->get('proto')->setValue($history->getProto()->getId());



        if ($this->request->isPost()) {
            $postedData = $this->request->getPost();
            $form->setData($postedData);
            if ($form->isValid()) {
                
                if ($history->getProtoStatus()->getId() == \Proto\Entity\Status::STATUS_TYPE_DELIVERED) {
                    $proto = $history->getProto();
                    $proto->setEndDate($history->getEditDate());
                    $protoMapper = $this->getServiceLocator()->get('Proto\Mapper\ProtoMapper');
                    $protoMapper->update($proto);
                }
                


                
                
                $this->historyMapper->update($history);
                $this->flashMessenger()->setNamespace('success')->addMessage('Storico modificato con successo');

                return $this->redirect()->toRoute('proto/edit', array('protoId' => $history->getProto()->getId()));
            } else {
                var_dump($form->getValidationGroup());
            }
        }


        return array('form' => $form, 'proto' => $history->getProto());
    }

    public function removeAction()
    {
        //Solo autorizzai (permissione: proto.edit)
        if (!$this->getAuthorizationService()->isGranted('proto.edit')) {
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
        if (strpos($redirectUrl, 'proto/edit') !== false) {
            return $this->redirect()->toUrl($redirectUrl);
        }

        return $this->redirect()->toRoute('proto/history');
    }


}
