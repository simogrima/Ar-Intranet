<?php

/**
 * Computer\Controller\Category
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
use Computer\Form\CategoryForm;


class CategoryController extends EntityUsingController
{
    /**
     * @var Computer\Options\ModuleOptions
     */
    protected $options;

    /**
     *
     * @var type Computer\Mapper\CategoryMapper
     */
    protected $categoryMapper;

    public function __construct($options, $mapper)
    {
        $this->options = $options;
        $this->categoryMapper = $mapper;
    }    
    
    public function indexAction()
    {
        $categories = $this->categoryMapper->findAll();
        if (is_array($categories)) {
            $paginator = new Paginator\Paginator(new Paginator\Adapter\ArrayAdapter($categories));
        } else {
            $paginator = $categories;
        }

        $paginator->setItemCountPerPage(30);
        $paginator->setCurrentPageNumber($this->getEvent()->getRouteMatch()->getParam('page'));
        return array(
            'categories' => $paginator,
            'pageAction' => 'computer/category',
        );
    }    

    public function createAction()
    {
        // Create the form and inject the ObjectManager
        $form = new CategoryForm($this->getEntityManager());

        // Create a new, empty entity and bind it to the form
        $class = $this->options->getCategoryEntityClass();
        $category = new $class();
        $form->bind($category);

        if ($this->request->isPost()) {
            $form->setData($this->request->getPost());
            if ($form->isValid()) {
                $this->categoryMapper->insert($category);

                $this->flashMessenger()->setNamespace('success')->addMessage('Category added successfully');
                return $this->redirect()->toRoute('computer/category');
            }
        }

        return array('form' => $form);
    }    

    public function editAction()
    {
        // Get your ObjectManager from the ServiceManager
        $objectManager = $this->getEntityManager();

        $categoryId = $this->getEvent()->getRouteMatch()->getParam('categoryId');
        $category = $objectManager->getRepository($this->options->getCategoryEntityClass())->find($categoryId);

        // Create the form and inject the ObjectManager
        $form = new CategoryForm($objectManager);
        $form->bind($category);

        if ($this->request->isPost()) {
            $postedData = $this->request->getPost();
            $form->setData($postedData);
            if ($form->isValid()) {

                $this->categoryMapper->update($category);

                $this->flashMessenger()->setNamespace('success')->addMessage('Category edit successfully');
                return $this->redirect()->toRoute('computer/category');
            }
        }

        return array('form' => $form);
    }
    
    public function removeAction()
    {
        $categoryId = $this->getEvent()->getRouteMatch()->getParam('categoryId');
        $category = $this->getEntityManager()->getRepository($this->options->getCategoryEntityClass())->find($categoryId);

        if ($category) {
            $this->categoryMapper->remove($category);
            $this->flashMessenger()->addSuccessMessage('The category was deleted');
        }

        return $this->redirect()->toRoute('computer/category');
    }    

}
