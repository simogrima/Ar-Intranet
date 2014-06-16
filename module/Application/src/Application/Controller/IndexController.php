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
        $this->getServiceLocator()->get('Zend\Log')->info('Informational message'); 
        
        return new ViewModel();
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
                'username' => 'simogrima@gmail.com',
                'password' => 'alfolino72',
            ),
        ));


        $transport = new SmtpTransport();
        $transport->setOptions($options);
        $transport->send($message);        
    }

}
