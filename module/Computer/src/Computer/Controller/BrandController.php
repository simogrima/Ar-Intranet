<?php

/**
 * Computer\Controller\Brand
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
use Computer\Form\BrandForm;


class BrandController extends EntityUsingController
{
    /**
     * @var Computer\Options\ModuleOptions
     */
    protected $options;

    /**
     *
     * @var type Computer\Mapper\BrandMapper
     */
    protected $brandMapper;

    public function __construct($options, $mapper)
    {
        $this->options = $options;
        $this->brandMapper = $mapper;
    }    
    
    public function indexAction()
    {
        $brands = $this->brandMapper->findAll();
        if (is_array($brands)) {
            $paginator = new Paginator\Paginator(new Paginator\Adapter\ArrayAdapter($brands));
        } else {
            $paginator = $brands;
        }

        $paginator->setItemCountPerPage(30);
        $paginator->setCurrentPageNumber($this->getEvent()->getRouteMatch()->getParam('page'));
        return array(
            'brands' => $paginator,
            'pageAction' => 'computer/brand',
        );
    }    

    public function createAction()
    {
        // Get your ObjectManager from the ServiceManager
        $objectManager = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');

        // Create the form and inject the ObjectManager
        $form = new BrandForm($objectManager);

        // Create a new, empty entity and bind it to the form
        $class = $this->options->getBrandEntityClass();
        $brand = new $class();
        $form->bind($brand);

        if ($this->request->isPost()) {
            $form->setData($this->request->getPost());
            if ($form->isValid()) {
                $this->brandMapper->insert($brand);

                $this->flashMessenger()->setNamespace('success')->addMessage('Brand added successfully');
                return $this->redirect()->toRoute('computer/brand');
            }
        }

        return array('form' => $form);
    }    

    public function editAction()
    {
        // Get your ObjectManager from the ServiceManager
        $objectManager = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');

        $brandId = $this->getEvent()->getRouteMatch()->getParam('brandId');
        $brand = $objectManager->getRepository($this->options->getBrandEntityClass())->find($brandId);

        // Create the form and inject the ObjectManager
        $form = new BrandForm($objectManager);
        $form->bind($brand);

        if ($this->request->isPost()) {
            $postedData = $this->request->getPost();
            $form->setData($postedData);
            if ($form->isValid()) {

                $this->brandMapper->update($brand);

                $this->flashMessenger()->setNamespace('success')->addMessage('Brand edit successfully');
                return $this->redirect()->toRoute('computer/brand');
            }
        }

        return array('form' => $form);
    }
    
    public function removeAction()
    {
        // Get your ObjectManager from the ServiceManager
        $objectManager = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');

        $brandId = $this->getEvent()->getRouteMatch()->getParam('brandId');
        $brand = $objectManager->getRepository($this->options->getBrandEntityClass())->find($brandId);

        if ($brand) {
            $this->bradnMapper->remove($brand);
            $this->flashMessenger()->addSuccessMessage('The brand was deleted');
        }

        return $this->redirect()->toRoute('computer/brand');
    }    

}
