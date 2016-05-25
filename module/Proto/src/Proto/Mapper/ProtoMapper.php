<?php

namespace Proto\Mapper;

use MainModule\Mapper\Db\BaseDoctrine;
use Zend\View\Model\ViewModel;

class ProtoMapper extends BaseDoctrine
{

    public function findAll()
    {
        $er = $this->em->getRepository($this->options->getProtoEntityClass());
        return $er->findAll();
    }

    public function find($id)
    {
        $er = $this->em->getRepository($this->options->getProtoEntityClass());
        return $er->find($id);
    }

    /**
     * Counts how many Proto there are in the database
     *
     * @return int
     */
    public function count()
    {
        $query = $this->em->createQueryBuilder();
        $query->select(array('p.id'))
                ->from($this->options->getProtoEntityClass(), 'p');
        $result = $query->getQuery()->getResult();
        return count($result);
    }
    
    public function getFieldsSearchQuery($data, $orderBy, $order)
    {
        $qb = $this->em->createQueryBuilder();
        $qb->select(array('p'))
                ->from($this->options->getProtoEntityClass(), 'p')
                ->innerJoin('p.applicant', 'u')
                ->innerJoin('p.status', 't')
                ->innerJoin('p.family', 'f')
                ->orderBy($orderBy, $order);

        if (!empty($data)) {
            $whereString = '';
            $and = '';            
            foreach ($data as $key => $value) {
                switch ($key) {
                    case 'applicant':
                        $whereString .= $and . "u.id = ?2";
                        $qb->setParameter(2, trim($value));
                        break;                    
                    case 'status':
                        $whereString .= $and . "t.id = ?1";
                        $qb->setParameter(1,  trim($value));
                        break;
                    case 'family':
                        $whereString .= $and . "f.id = ?2";
                        $qb->setParameter(2,  trim($value));
                        break;                    
                    case 'id':
                        $whereString .= $and . "p.id = ?3";
                        $qb->setParameter(3,  trim($value));
                        break;                    
                    default:
                        $whereString .= $and . "p.$key LIKE :$key";
                        $qb->setParameter($key, '%' . trim($value) . '%');
                        break;
                }
                $and = ' AND ';                
            }
            $qb->where($whereString);
        }
        return $qb->getQuery();
    }    

    //Rimuovo, fisicamente, anche aventuali files allegati
    public function remove($entity)
    {
        $attachments = $entity->getAttachments();
        foreach ($attachments as $attachment) {
            $location = './public' . $this->options->getAttachmentPath() . $attachment->getFileName();
            unlink($location);
        }
        parent::remove($entity);
    }
 
    /**
     * Invia email che notifica una nuova richiesta
     * 
     * @param \Proto\Entity\Proto $entity
     * @param \Application\Controller\AbstractActionController $controller
     */
    public function sendNewRequestEmail($entity, $controller, $replyTo)
    {
        $urlViewHelper = $controller->getServiceLocator()->get('ViewHelperManager')->get('url');
        $view = new ViewModel(array(
            'proto' => $entity,
            'url' => $urlViewHelper('proto/show', array('protoId' => $entity->getId()), array('force_canonical' => true)),
        ));
        $view->setTerminal(true);
        $view->setTemplate('Proto/view/emails/new_request');
        $controller->mailerZF2()->send(array(
            'to' => $this->options->getEmailToNewRequest(),
            //'cc' => 'email2@domain.com',
            //'bcc' => 'email3@domain.com',    
            'replyTo' => $replyTo->getEmail(),
            'replyNameTo' => $replyTo->getDisplayName(),              
            'subject' => 'Nuova richiesta prototipo'
                ), $view);
    }    
    
    /**
     * Invia email che notifica cambio stato della richiesta
     * 
     * @param Proto\Entity\Proto $entity
     * @param namespace Application\Controller\AbstractActionController $controller
     */
    public function sendChangeStatusEmail($entity, $controller, $replyTo)
    {
        $urlViewHelper = $controller->getServiceLocator()->get('ViewHelperManager')->get('url');
        $view = new ViewModel(array(
            'proto' => $entity,
        ));
        $view->setTerminal(true);
        $view->setTemplate('Proto/view/emails/change_status');
        $controller->mailerZF2()->send(array(
            'to' => $entity->getApplicant()->getEmail(),
            'replyTo' => $replyTo->getEmail(),
            'replyNameTo' => $replyTo->getDisplayName(),                
            //'cc' => 'email2@domain.com',
            //'bcc' => 'email3@domain.com',    
            'subject' => "Richiesta prototipo {$entity->getId()} passa allo stato: {$entity->getStatus()->getName()}",
                ), $view);
    }    
      

}
