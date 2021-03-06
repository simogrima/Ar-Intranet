<?php

/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Mail\Message;
use Zend\Mail\Transport\Smtp as SmtpTransport;
use Zend\Mail\Transport\SmtpOptions;

class IndexController extends AbstractActionController
{

    public function indexAction()
    {     
        //test log
        //$this->getServiceLocator()->get('Zend\Log')->info('Informational message'); 

        return array(
            'computerCount' => $this->getServiceLocator()->get('Computer\Mapper\ComputerMapper')->count(),
            'samplesCount' => $this->getServiceLocator()->get('Samples\Mapper\SampleMapper')->count(),
            'prototypingCount' => $this->getServiceLocator()->get('Prototyping\Mapper\PrototypingMapper')->count(),
        );
    }

    public function functionName($param)
    {

        /* Mail test */
        $message = new Message();
        $message->setEncoding("UTF-8");
        $message->addFrom("simogrima@gmail.com", "Simone Grimani")
                ->addTo("simogrima@gmail.com")
                ->setSubject("Sending an email from Zend\Mail!");
        $message->setBody("This is the message body.");

        //$transport = new SendmailTransport();
        //($transport->send($message);
        //Ariete
        $options = new SmtpOptions(array(
            'name' => 'ariete.net',
            'host' => 'mail.ariete.net',
            'connection_class' => 'login',
            'connection_config' => array(
                'username' => 'grimani',
                'password' => 'kk78',
            ),
        ));

        //Gmail
        $options = new SmtpOptions(array(
            'name' => 'gmail.com',
            'host' => 'smtp.gmail.com',
            'connection_class' => 'login',
            'port' => '465',
            'connection_config' => array(
                'ssl' => 'ssl', /* Page would hang without this line being added */
                'username' => 'mygoogle@email',
                'password' => 'mygooglepsw',
            ),
        ));


        $transport = new SmtpTransport();
        $transport->setOptions($options);
        $transport->send($message);
    }
    
    /**
     * Tengo questo codice che ho usato per fare inserimento massivo utenti
     */
    public function AddUsers()
    {
        //Insertimento massivi utenti da file csv su /public
        set_time_limit(1800);
        ini_set('memory_limit', '-1');
        
        $objectManager = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
        $userService = $this->getServiceLocator()->get('zfcuser_user_service');
        
        //Ottengo il ruolo (guest) da assegnare di default
        $role = $objectManager->getRepository('MyZfcRbac\Entity\FlatRole')->find(1);        
        
        $users = fopen('./public/users.csv', "r");
        if (($handle = $users) !== FALSE) {
            while (($data = fgetcsv($handle, 0, ";")) !== FALSE) {
                $email = strtolower(trim($data[0]));                
                $a = explode('@', $email);
                $b = explode('.', $a[0]);
                $name = ucfirst($b[0]);
                $lastname = ucfirst($b[1]);
                $psw = '123456';
                
                $data = [
                    'display_name' => $name . ' ' . $lastname,
                    'username' => $name . $lastname,
                    'password' => $psw,
                    'passwordVerify' => $psw,
                    'email' => strtolower($email),
                ];
                
                //Aggiungo utente
                $user = $userService->register($data);     
                
                //Assegno ruolo di default
                $user->addRole($role);
                $objectManager->persist($role);
            }
            
            //Flush assegnazione ruoli
            $objectManager->flush(); 
        }        
    }        
    
    /**
     * Setta su tutti gli utenti la psw di default
     * url: /application/index/set-default-psw
     */
    public function setDefaultPswAction()
    {
        //bloccato
        return $this->getResponse();
        
        set_time_limit(1800);
        ini_set('memory_limit', '-1');
        
        $objectManager = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
        $userService = $this->getServiceLocator()->get('zfcuser_user_service');
        
        //Ottengo il ruolo "guest" per accedere a login
        $roleGuest = $objectManager->getRepository('MyZfcRbac\Entity\FlatRole')->find(1);
        //Ottengo il ruolo "user" per accedere all'intranet dopo logon
        $roleUser = $objectManager->getRepository('MyZfcRbac\Entity\FlatRole')->find(3);
        
        
        $users = $this->getServiceLocator()->get('zfcuser_user_mapper')->findAll();
        foreach ($users as $user) {
            if ($user->getEmail() != 'grimani@ariete.net') {
                echo $user->getEmail();
                 
                
                //Aggiorno psw
                $psw = '123456';
                $data = ['password' => $psw, 'passwordVerify' => $psw];        
                //$user = $userService->register($data);  
                echo ' [upd psw] ';
                
                
                
                 //Assegno ruoli guest ed user (se non li ha)
                if (!$user->hasRole($roleGuest->getName())) {
                    $user->addRole($roleGuest); 
                    echo ' [aggiunto ruolo guest] ';
                }
                if (!$user->hasRole($roleUser->getName())) {
                    $user->addRole($roleUser);
                    echo ' [aggiunto ruolo user] ';
                }                  
            
                $this->getServiceLocator()->get('zfcuser_user_mapper')->update($user)          ;
                echo '<br/>';
            }
        }
        
        return $this->getResponse();
    }       

    /**
     * X campo destinatari.
     * Vedi view helper Application\View\Helper\RecipientsInputElement
     * url: /application/index/json-users
     */    
    public function jsonUsersAction()
    {
        $users = $this->getServiceLocator()->get('zfcuser_user_mapper')->findAll();
        $data = [];
        foreach ($users as $user) {
            $data[] = [
                'value' => $user->getEmail(),
                'text' => $user->getDisplayName(),
            ];
        }
        $jsonObject = \Zend\Json\Json::encode($data, true);
        echo $jsonObject;
        return $this->getResponse();
    }        

}
