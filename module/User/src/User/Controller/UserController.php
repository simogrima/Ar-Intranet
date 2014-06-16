<?php

namespace User\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

use ZfcUser\Service\User as UserService,
        ZfcUser\Options\UserControllerOptionsInterface,
        ZfcUser\Controller\UserController as ZfcUserController;

class UserController extends ZfcUserController
{

    /**
     * @var Doctrine\ORM\EntityManager
     */
    protected $em;

    public function getEntityManager()
    {
        if (null === $this->em) {
            $this->em = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
        }
        return $this->em;
    }


    
    public function loginaAction()
    {
        echo 'aaaaaaaaaaa';
        return FALSE;
    }  
    
    public function fooAction()
    {
        echo 'fooooooo';
        return FALSE;
    }  

}
