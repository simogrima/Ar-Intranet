<?php

/**
 * Attachments\Controller
 *
 * @author Simone Grimani
 * @copyright  Copyright (c) 2014 Simone Grimani (http://www.simogrima.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

namespace Samples\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Application\Controller\EntityUsingController;
use Samples\Entity\Attachments;
use Zend\Paginator;
use Zend\Stdlib\Hydrator\ClassMethods;
use Zend\View\Model\ViewModel;
//Doctrine
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Doctrine\ORM\Tools\Pagination\Paginator as ORMPaginator;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator;
//Form
use Samples\Form\MultiHtml5Upload;
use Application\Form\SearchForm;

class AttachmentsController extends EntityUsingController
{

    /**
     * @var Samples\Options\ModuleOptions
     */
    protected $options;

    /**
     *
     * @var type Samples\Mapper\AttachmentsMapper
     */
    protected $attachmentsMapper;

    public function __construct($options, $mapper)
    {
        $this->options = $options;
        $this->attachmentsMapper = $mapper;
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
                new DoctrinePaginator(new ORMPaginator($this->attachmentsMapper->getSearchQuery($searchString, 's.' . $order_by, $order)))
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
            'attachments' => $paginator,
            'pageAction' => 'samples/attachments/list',
            'attachmentPath' => $this->options->getAttachmentPath(),
        );
    }

    public function createAction()
    {
        // Get your ObjectManager from the ServiceManager
        $objectManager = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');

        // Create the form and inject the ObjectManager
        $form = new MultiHtml5Upload($objectManager);

        // Create a new, empty entity and bind it to the form
        $class = $this->options->getSampleEntityClass();
        $sample = new $class();
        $form->bind($sample);

        if ($this->request->isPost()) {
            $form->setData($this->request->getPost());
            if ($form->isValid()) {
                $this->sampleMapper->insert($sample);

                $this->flashMessenger()->setNamespace('success')->addMessage('Sample added successfully');
                return $this->redirect()->toRoute('samples/list');
            }
        }

        return array('form' => $form);
    }

    public function addAction()
    {
        $form = new MultiHtml5Upload('file-form', array('attachmentPath' => $this->options->getAttachmentPath()));

        $sampleId = $this->getEvent()->getRouteMatch()->getParam('sample_id');
        $attachmentType = $this->getEvent()->getRouteMatch()->getParam('type');

        //Ottengo campionatura
        $sample = $this->getServiceLocator()->get('Samples\Mapper\SampleMapper')->find((int) $sampleId);
        if (!$sample) {
            throw new \Exception(
            sprintf('Campionatura non trovata!')
            );
        }        

        //Controllo il tipo
        if (!in_array($attachmentType, Attachments::getAttachmentTypeValues())) {
            throw new \InvalidArgumentException(
            sprintf('Invalid value for attachment.attachmentType : %s.', $attachmentType)
            );
        }



        if ($this->getRequest()->isPost()) {
            // Postback
            $data = array_merge_recursive(
                    $this->getRequest()->getPost()->toArray(), $this->getRequest()->getFiles()->toArray()
            );

            $form->setData($data);

            if ($form->isValid()) {


                $formData = $form->getData();


                foreach ($formData['file'] as $file) {
                    $data = array(
                        'sample' => $sample,
                        'attachmentType' => $attachmentType,
                        'fileName' => basename($file['tmp_name']),
                    );
                    $this->addAttachment($data);
                }


                //
                // ...Save the form...
                //
                //var_dump($form->getData());

                $this->flashMessenger()->setNamespace('success')->addMessage('Allegati aggiunti con successo!');
                if ($attachmentType == 'richiesta') {
                    return $this->redirect()->toRoute('samples/list');
                }
                return $this->redirect()->toRoute('samples/edit', array('sampleId' => $sample->getId()));
                //return $this->redirectToSuccessPage($form->getData());
            }
        }

        $queryData = $this->getEvent()->getRouteMatch()->getParams();
        $form->setData($queryData);

        $view = new ViewModel(array(
            'legend' => 'Aggiungi allegati alla richiesta',
            'form' => $form,
            'sample' => $sample,
            'type' => $attachmentType,
        ));
        return $view;
    }

    public function removeAction()
    {
        //Solo superuser
        if (!$this->getAuthorizationService()->isGranted('computer.superuser')) {
            //throw new UnauthorizedException();
        }

        $objectManager = $this->getEntityManager();

        $attachmentId = $this->getEvent()->getRouteMatch()->getParam('attachmentId');
        $attachment = $objectManager->getRepository($this->options->getAttachmentsEntityClass())->find($attachmentId);

        if ($attachment) {
            $sample = $attachment->getSample(); //per redirect
            $this->attachmentsMapper->remove($attachment);
            $this->flashMessenger()->addSuccessMessage('Allegato eliminato con successo!');
        }

        return $this->redirect()->toRoute('samples/edit', array('sampleId' => $sample->getId()));
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

    /**
     * Aggiunge un record alla tabella sample_attachment.
     * 
     * @param array $data
     */
    protected function addAttachment($data)
    {
        $attachmentClass = $this->options->getAttachmentsEntityClass();
        $attachment = new $attachmentClass();
        $hydrator = new DoctrineHydrator($this->getEntityManager(), $attachmentClass);
        $attachment = $hydrator->hydrate($data, $attachment);

        //var_dump($history);
        $this->attachmentsMapper->update($attachment);
        //$this->flashMessenger()->setNamespace('success')->addMessage('Attachment add successfully');
    }

}
