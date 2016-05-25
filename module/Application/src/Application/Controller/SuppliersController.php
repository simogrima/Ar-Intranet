<?php

/**
 * Application\Controller\Suppliers
 *
 * @author Simone Grimani
 * @copyright  Copyright (c) 2014 Simone Grimani (http://www.simogrima.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Application\Controller\EntityUsingController;
use Application\Entity\Supplier;
use Zend\Paginator;
use Zend\Stdlib\Hydrator\ClassMethods;
use Zend\View\Model\ViewModel;
//Doctrine
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use Doctrine\ORM\Tools\Pagination\Paginator as ORMPaginator;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator;
//Form
use Application\Form\SupplierForm;
use Application\Form\SearchForm;

//ZfcRbac
use ZfcRbac\Exception\UnauthorizedException;

class SuppliersController extends EntityUsingController
{

    /**
     * @var Proto\Options\ModuleOptions
     */
    protected $options;

    /**
     *
     * @var type Application\Mapper\SuppliersMapper
     */
    protected $suppliersMapper;

    public function __construct($options, $mapper)
    {
        $this->options = $options;
        $this->suppliersMapper = $mapper;
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
                new DoctrinePaginator(new ORMPaginator($this->suppliersMapper->getSearchQuery($searchString, 's.' . $order_by, $order)))
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
            'suppliers' => $paginator,
            'pageAction' => 'application/suppliers/list',
        );
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

    public function editAction()
    {
        //Solo autorizzai (permissione: supplier.edit)
        if (!$this->getAuthorizationService()->isGranted('supplier.edit')) {
            throw new UnauthorizedException();
        }

        // Get your ObjectManager from the ServiceManager
        $objectManager = $this->getEntityManager();

        $supplierId = $this->getEvent()->getRouteMatch()->getParam('supplierId');
        $supplier = $objectManager->getRepository($this->options->getSuppliersEntityClass())->find($supplierId);
        
        if (!$supplier) {
            throw new \Exception(
            sprintf('Fornitore non trovato!')
            );
        }         

        // Create the form and inject the ObjectManager
        $form = new SupplierForm($objectManager);
        $form->bind($supplier);

        if ($this->request->isPost()) {
            $postedData = $this->request->getPost();
            $form->setData($postedData);
            if ($form->isValid()) {
                
                $this->suppliersMapper->update($supplier);
                $this->flashMessenger()->setNamespace('success')->addMessage('Fornitore modificato con successo');

                return $this->redirect()->toRoute('application/suppliers/list');
            } else {
                var_dump($form->getValidationGroup());
            }
        }


        return array('form' => $form);
    }

    public function removeAction()
    {
        /**
         * Solo autorizzai (permissione: supplier.remove) non esiste la permissione. 
         * Lo faccio apposta xchè voglio bloccare eliminazine. Altre tabelle potrebbero utilizzare il fornitore!!!
         */
        if (!$this->getAuthorizationService()->isGranted('supplier.remove')) {
            throw new UnauthorizedException();
        }

        $supplierId = $this->getEvent()->getRouteMatch()->getParam('supplierId');
        $supplier = $this->getEntityManager()->getRepository($this->options->getSuppliersEntityClass())->find($supplierId);

        if ($supplier) {
            $this->suppliersMapper->remove($supplier);
            $this->flashMessenger()->addSuccessMessage('Il fornitore è stato eliminato');
        }

        return $this->redirect()->toRoute('application/suppliers/list');
    }
    
    public function addAction()
    {
        //Solo autorizzai (permissione: supplier.edit)
        if (!$this->getAuthorizationService()->isGranted('supplier.edit')) {
            throw new UnauthorizedException();
        }
        
        $objectManager = $this->getEntityManager();
        $form = new SupplierForm($objectManager);        
        
        // Create a new, empty entity and bind it to the form
        $class = $this->options->getSuppliersEntityClass();
        $supplier = new $class();
        $form->bind($supplier);        

        if ($this->getRequest()->isPost()) {
            $form->setData($this->request->getPost());

            if ($form->isValid()) {
                $this->suppliersMapper->insert($supplier);
                //
                // ...Save the form...
                //
                //var_dump($form->getData());
                
                $this->flashMessenger()->setNamespace('success')->addMessage('Fornitore aggiunto con successo!');
                return $this->redirect()->toRoute('application/suppliers/list');
                //return $this->redirectToSuccessPage($form->getData());
            }
        }    
        
        return array('form' => $form);
    }    

}
