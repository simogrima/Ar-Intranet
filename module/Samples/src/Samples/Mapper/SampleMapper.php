<?php

namespace Samples\Mapper;

use MainModule\Mapper\Db\BaseDoctrine;
use Zend\View\Model\ViewModel;

class SampleMapper extends BaseDoctrine
{

    public function findAll()
    {
        $er = $this->em->getRepository($this->options->getSampleEntityClass());
        return $er->findAll();
    }

    public function find($id)
    {
        $er = $this->em->getRepository($this->options->getSampleEntityClass());
        return $er->find($id);
    }

    /**
     * Counts how many samples there are in the database
     *
     * @return int
     */
    public function count()
    {
        $query = $this->em->createQueryBuilder();
        $query->select(array('s.id'))
                ->from($this->options->getSampleEntityClass(), 's');
        $result = $query->getQuery()->getResult();
        return count($result);
    }

    public function getSearchQuery($searchString, $orderBy, $order)
    {
        $qb = $this->em->createQueryBuilder();
        $qb->select(array('s'))
                ->from($this->options->getSampleEntityClass(), 's')
                ->innerJoin('s.applicant', 'u')
                ->innerJoin('s.status', 't')
                ->where(
                        $qb->expr()->orX(
                                $qb->expr()->like('s.customer', '?1'), $qb->expr()->like('s.model', '?1'), $qb->expr()->like('u.displayName', '?1'), $qb->expr()->like('t.name', '?1')
                ))
                ->setParameter(1, '%' . $searchString . '%')
                ->orderBy($orderBy, $order);
        return $qb->getQuery();
    }

    public function getFieldsSearchQuery($data, $orderBy, $order)
    {
        $qb = $this->em->createQueryBuilder();
        $qb->select(array('s'))
                ->from($this->options->getSampleEntityClass(), 's')
                ->innerJoin('s.applicant', 'u')
                ->innerJoin('s.status', 't')
                ->orderBy($orderBy, $order);

        if (!empty($data)) {
            $whereString = '';
            $and = '';            
            foreach ($data as $key => $value) {
                switch ($key) {
                    case 'status':
                        $whereString .= $and . "t.id = ?1";
                        $qb->setParameter(1,  trim($value));
                        break;
                    case 'applicant':
                        $whereString .= $and . "u.id = ?2";
                        $qb->setParameter(2, trim($value));
                        break;
                    case 'id':
                        $whereString .= $and . "s.id = ?3";
                        $qb->setParameter(3,  trim($value));
                        break;                    
                    default:
                        $whereString .= $and . "s.$key LIKE :$key";
                        $qb->setParameter($key, '%' . trim($value) . '%');
                        break;
                }
                $and = ' AND ';                
            }
            $qb->where($whereString);
        }
        return $qb->getQuery();
    }
    
    //Ottiene le campionature aperte di un utente                
    public function getActiveByUser($userId, $orderBy, $order)
    {
        $qb = $this->em->createQueryBuilder();
        $qb->select(array('s'))
                ->from($this->options->getSampleEntityClass(), 's')
                ->innerJoin('s.applicant', 'u')
                ->innerJoin('s.status', 't')
                ->where(
                        $qb->expr()->orX(
                                $qb->expr()->eq('t.id', '?1'), $qb->expr()->eq('t.id', '?2'), $qb->expr()->eq('t.id', '?3')
                ))
                ->andWhere(
                        $qb->expr()->andX(
                                $qb->expr()->eq('u.id', '?4')
                ))                
                ->setParameter(1, \Samples\Entity\Status::STATUS_TYPE_PENDING_EVASION)
                ->setParameter(2, \Samples\Entity\Status::STATUS_TYPE_PRODUCT_REQUIRED)
                ->setParameter(3, \Samples\Entity\Status::STATUS_TYPE_PRODUCT_ARRIVED)
                ->setParameter(4, (int) $userId)
            
                ->orderBy($orderBy, $order);
        return $qb->getQuery();
    }    

    public function getActive($orderBy, $order)
    {
        $qb = $this->em->createQueryBuilder();
        $qb->select(array('s'))
                ->from($this->options->getSampleEntityClass(), 's')
                ->innerJoin('s.applicant', 'u')
                ->innerJoin('s.status', 't')
                ->where(
                        $qb->expr()->orX(
                                $qb->expr()->eq('t.id', '?1'), $qb->expr()->eq('t.id', '?2'), $qb->expr()->eq('t.id', '?3')
                ))
                ->setParameter(1, \Samples\Entity\Status::STATUS_TYPE_PENDING_EVASION)
                ->setParameter(2, \Samples\Entity\Status::STATUS_TYPE_PRODUCT_REQUIRED)
                ->setParameter(3, \Samples\Entity\Status::STATUS_TYPE_PRODUCT_ARRIVED)
                ->orderBy($orderBy, $order);
        return $qb->getQuery();
    }
    
    /**
     * Evase non ancora comuncate a magazzino.
     * Stato = evase (STATUS_TYPE_PROCESSED)
     * Email2 = 0
     */
    public function getProcessed($orderBy, $order)
    {
        $qb = $this->em->createQueryBuilder();
        $qb->select(array('s'))
                ->from($this->options->getSampleEntityClass(), 's')
                ->innerJoin('s.applicant', 'u')
                ->innerJoin('s.status', 't')
                ->where(
                        $qb->expr()->andX(
                                $qb->expr()->eq('t.id', '?1'), $qb->expr()->eq('s.email2', '?2')
                ))
                ->setParameter(1, \Samples\Entity\Status::STATUS_TYPE_PROCESSED)
                ->setParameter(2, 0)
                ->orderBy($orderBy, $order);
        return $qb->getQuery();
    }    
    
    /**
     * Campionature da spedire.
     * Stato = evase (STATUS_TYPE_PROCESSED)
     * Email2 = 1
     */    
    public function getToShip($orderBy, $order)
    {
        $qb = $this->em->createQueryBuilder();
        $qb->select(array('s'))
                ->from($this->options->getSampleEntityClass(), 's')
                ->innerJoin('s.applicant', 'u')
                ->innerJoin('s.status', 't')
                ->where(
                        $qb->expr()->andX(
                                $qb->expr()->eq('t.id', '?1'), $qb->expr()->eq('s.email2', '?2')
                ))
                ->setParameter(1, \Samples\Entity\Status::STATUS_TYPE_PROCESSED)
                ->setParameter(2, 1);
        
                if ($orderBy == 's.disabled') {
                    $qb->addOrderBy('s.email1', 'ASC')
                       ->addOrderBy('s.id', 'DESC');
                } else {
                    $qb->orderBy($orderBy, $order);
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
     * Invia email che notifica annullamento campione
     * 
     * @param Samples\Entity\Sample $entity
     * @param namespace Application\Controller\AbstractActionController $controller
     */
    public function sendCanceledSampleEmail($entity, $controller, $replyTo)
    {
        $urlViewHelper = $controller->getServiceLocator()->get('ViewHelperManager')->get('url');
        $view = new ViewModel(array(
            'sample' => $entity,
            'url' => $urlViewHelper('samples/show', array('sampleId' => $entity->getId()), array('force_canonical' => true)),
        ));
        $view->setTerminal(true);
        $view->setTemplate('Samples/view/emails/sample_canceled');
        $controller->mailerZF2()->send(array(
            'to' => $entity->getApplicant()->getEmail(),
            'replyTo' => $replyTo->getEmail(),
            'replyNameTo' => $replyTo->getDisplayName(),                
            //'cc' => 'email2@domain.com',
            //'bcc' => 'email3@domain.com',    
            'subject' => 'Campionatura annullata',
                ), $view);
    }

    /**
     * Invia email che notifica evasione campioni
     * 
     * @param array $samples
     * @param \Application\Controller\AbstractActionController $controller
     */
    public function sendProcessedSampleEmail($samples, $controller, $replyTo)
    {
        //Stabilisco detinatari (default + richiedente)
        $emailTo = $this->options->getEmailToProcessedSample();
        //$emailTo[] = $entity->getApplicant()->getEmail();//tolgo richiedente

        $view = new ViewModel(array(
            'samples' => $samples,
        ));
        $view->setTerminal(true);
        $view->setTemplate('Samples/view/emails/samples_processed');
        $controller->mailerZF2()->send(array(
            'to' => $emailTo,
            'replyTo' => $replyTo->getEmail(),
            'replyNameTo' => $replyTo->getDisplayName(),              
            //'cc' => 'email2@domain.com',
            //'bcc' => 'email3@domain.com',    
            'subject' => 'Campionature evase',
                ), $view);
    }

    /**
     * Invia email che notifica una nuova richiesta di campionatura
     * 
     * @param \Samples\Entity\Sample $entity
     * @param \Application\Controller\AbstractActionController $controller
     */
    public function sendNewSampleEmail($entity, $controller, $replyTo)
    {
        $urlViewHelper = $controller->getServiceLocator()->get('ViewHelperManager')->get('url');
        $view = new ViewModel(array(
            'sample' => $entity,
            'url' => $urlViewHelper('samples/show', array('sampleId' => $entity->getId()), array('force_canonical' => true)),
        ));
        $view->setTerminal(true);
        $view->setTemplate('Samples/view/emails/new_sample');
        $controller->mailerZF2()->send(array(
            'to' => $this->options->getEmailToNewSample(),
            //'cc' => 'email2@domain.com',
            //'bcc' => 'email3@domain.com',    
            'replyTo' => $replyTo->getEmail(),
            'replyNameTo' => $replyTo->getDisplayName(),              
            'subject' => 'Nuova campionatura richiesta'
                ), $view);
    }
    
    /**
     * Invia email che notifica che la spedizione è stata preparata.
     * 
     * @param array $samples le campionature
     * @param array $data colli, pesi, misure, note
     * @param \Application\Controller\AbstractActionController $controller
     */
    public function sendShippingReadyEmail($samples, $data, $controller, $replyTo)
    {
        //Stabilisco detinatari (default + richiedente/i)
        $emailTo = $this->options->getEmailToShippingReady();
        foreach ($samples as $sample) {
           $emailTo[] = $sample->getApplicant()->getEmail();
        }
        $emailTo = array_unique($emailTo);
   
        $view = new ViewModel(array(
            'samples' => $samples,
            'data' => $data,
        ));
        $view->setTerminal(true);
        $view->setTemplate('Samples/view/emails/shipping_ready');
        $controller->mailerZF2()->send(array(
            'to' => $emailTo,
            'replyTo' => $replyTo->getEmail(),
            'replyNameTo' => $replyTo->getDisplayName(),            
            //'cc' => 'email2@domain.com',
            //'bcc' => 'email3@domain.com',    
            'subject' => 'Campionature pronte'
                ), $view);
    }    
    
    /**
     * Invia email che notifica di prodotto richiesto (x richiesta multipla da apposita form).
     * 
     * @param array $data messaggio
     * @param \Application\Controller\AbstractActionController $controller
     */
    public function sendProductRequiredEmail($data, $controller, $replyTo)
    {
        //Stabilisco detinatari (default)
        $emailTo = $this->options->getEmailToProductRequired();
        $emailTo = array_unique($emailTo);
   
        $view = new ViewModel(array(
            'data' => $data,
        ));
        $view->setTerminal(true);
        $view->setTemplate('Samples/view/emails/product_required');
        $controller->mailerZF2()->send(array(
            'to' => $emailTo,
            'replyTo' => $replyTo->getEmail(),
            'replyNameTo' => $replyTo->getDisplayName(),            
            //'cc' => 'email2@domain.com',
            //'bcc' => 'email3@domain.com',    
            'subject' => 'Campionature - richiesta prodotti'
                ), $view);
    }        
    
    /**
     * Invia email che notifica che il prodotto è stato inviato ad Ariete.
     * (Cioè è disponibile presso uff campioni)
     * 
     * @param array $data messaggio
     * @param \Application\Controller\AbstractActionController $controller
     */    
    public function sendGenericEmail($data, $subject, $controller, $emailTo, $replyTo)
    {
        $emailTo = array_unique($emailTo);
   
        $view = new ViewModel(array(
            'data' => $data,
        ));
        $view->setTerminal(true);
        $view->setTemplate('Samples/view/emails/generic');
        $controller->mailerZF2()->send(array(
            'to' => $emailTo,
            'replyTo' => $replyTo->getEmail(),
            'replyNameTo' => $replyTo->getDisplayName(),            
            //'cc' => 'email2@domain.com',
            //'bcc' => 'email3@domain.com',    
            'subject' => $subject
                ), $view);
    }           

}
