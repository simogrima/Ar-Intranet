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
//Form
use Samples\Form\MultiHtml5Upload;


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
        $attachments = $this->attachmentsMapper->findAll();
        if (is_array($attachments)) {
            $paginator = new Paginator\Paginator(new Paginator\Adapter\ArrayAdapter($attachments));
        } else {
            $paginator = $attachments;
        }

        $paginator->setItemCountPerPage(30);
        $paginator->setCurrentPageNumber($this->getEvent()->getRouteMatch()->getParam('page'));
        return array(
            'attachments' => $paginator,
            //'rolelistElements' => $this->options->getRoleListElements(),
            'pageAction' => 'attachments/list',
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
        $form = new MultiHtml5Upload('file-form');

            var_dump($this->getRequest()->isPost());
            var_dump(\Samples\Entity\Attachments::getAttachmentTypeValues());
        if ($this->getRequest()->isPost()) {
            // Postback
            $data = array_merge_recursive(
                $this->getRequest()->getPost()->toArray(),
                $this->getRequest()->getFiles()->toArray()
            );

            $form->setData($data);

            if ($form->isValid()) {
                
                
                $formData = $form->getData();

                //Ottengo campionatura
                $sample = $this->getServiceLocator()->get('Samples\Mapper\SampleMapper')->find((int) $formData['sample_id']);
               
                //Controllo il tipo
                $attachmentType = $formData['type'];
    	        if (!in_array($attachmentType, Attachments::getAttachmentTypeValues())) {
    		    throw new \InvalidArgumentException(
		        sprintf('Invalid value for attachment.attachmentType : %s.', $attachmentType)
    		    );
    	        }
                
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
                var_dump($form->getData());
                
                return;
                $this->flashMessenger()->setNamespace('success')->addMessage('Campionatura aggiunta con successo!');
                return $this->redirect()->toRoute('samples/list');
                return $this->redirectToSuccessPage($form->getData());
            }
        }
        
                $sampleId = $this->getEvent()->getRouteMatch()->getParam('sample_id');
        $type = $this->getEvent()->getRouteMatch()->getParam('type');
        
            $queryData = $this->getEvent()->getRouteMatch()->getParams();
            $form->setData($queryData);

        $view = new ViewModel(array(
           'legend' => 'Aggiungi allegati alla richiesta [facoltativo]',
           'form'   => $form,
        ));
        return $view;
    }    

    public function editAction()
    {
        // Get your ObjectManager from the ServiceManager
        $objectManager = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');

        $sampleId = $this->getEvent()->getRouteMatch()->getParam('sampleId');
        $sample = $objectManager->getRepository($this->options->getSampleEntityClass())->find($sampleId);

        // Create the form and inject the ObjectManager
        $form = new SampleForm($objectManager);
        $form->bind($sample);

        if ($this->request->isPost()) {
            $postedData = $this->request->getPost();
            $form->setData($postedData);
            if ($form->isValid()) {

                $this->sampleMapper->update($sample);

                $this->flashMessenger()->setNamespace('success')->addMessage('Samples edit successfully');
                return $this->redirect()->toRoute('samples/list');
            }
        }

        return array('form' => $form);
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
