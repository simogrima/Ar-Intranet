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
    
    public function getToShip($orderBy, $order)
    {
        $qb = $this->em->createQueryBuilder();
        $qb->select(array('s'))
                ->from($this->options->getSampleEntityClass(), 's')
                ->innerJoin('s.applicant', 'u')
                ->innerJoin('s.status', 't')
                ->where(
                        $qb->expr()->orX(
                                $qb->expr()->eq('t.id', '?1')
                ))
                ->setParameter(1, \Samples\Entity\Status::STATUS_TYPE_PROCESSED)
                ->orderBy($orderBy, $order);
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
    public function sendCanceledSampleEmail($entity, $controller)
    {
        $urlViewHelper = $controller->getServiceLocator()->get('ViewHelperManager')->get('url');
        $view = new ViewModel(array(
            'id' => $entity->getId(),
            'url' => $urlViewHelper('samples/show', array('sampleId' => $entity->getId()), array('force_canonical' => true)),
        ));
        $view->setTerminal(true);
        $view->setTemplate('Samples/view/emails/sample_canceled');
        $controller->mailerZF2()->send(array(
            'to' => $entity->getApplicant()->getEmail(),
            //'cc' => 'email2@domain.com',
            //'bcc' => 'email3@domain.com',    
            'subject' => 'Campionatura annullata',
                ), $view);
    }

    /**
     * Invia email che notifica evasione campione
     * 
     * @param \Samples\Entity\Sample $entity
     * @param \Application\Controller\AbstractActionController $controller
     */
    public function sendProcessedSampleEmail($entity, $controller)
    {
        //Stabilisco detinatari (default + richiedente)
        $emailTo = $this->options->getEmailToProcessedSample();
        $emailTo[] = $entity->getApplicant()->getEmail();

        $urlViewHelper = $controller->getServiceLocator()->get('ViewHelperManager')->get('url');
        $view = new ViewModel(array(
            'id' => $entity->getId(),
            'model' => $entity->getModel(),
            'url' => $urlViewHelper('samples/show', array('sampleId' => $entity->getId()), array('force_canonical' => true)),
        ));
        $view->setTerminal(true);
        $view->setTemplate('Samples/view/emails/sample_processed');
        $controller->mailerZF2()->send(array(
            'to' => $emailTo,
            //'cc' => 'email2@domain.com',
            //'bcc' => 'email3@domain.com',    
            'subject' => 'Campionatura evasa',
                ), $view);
    }

    /**
     * Invia email che notifica una nuova richiesta di campionatura
     * 
     * @param \Samples\Entity\Sample $entity
     * @param \Application\Controller\AbstractActionController $controller
     */
    public function sendNewSampleEmail($entity, $controller)
    {
        $urlViewHelper = $controller->getServiceLocator()->get('ViewHelperManager')->get('url');
        $view = new ViewModel(array(
            'id' => $entity->getId(),
            'applicant' => $entity->getApplicant()->getDisplayname(),
            'model' => $entity->getModel(),
            'customer' => $entity->getCustomer(),
            'note' => nl2br($entity->getNote()),
            'url' => $urlViewHelper('samples/show', array('sampleId' => $entity->getId()), array('force_canonical' => true)),
        ));
        $view->setTerminal(true);
        $view->setTemplate('Samples/view/emails/new_sample');
        $controller->mailerZF2()->send(array(
            'to' => $this->options->getEmailToNewSample(),
            //'cc' => 'email2@domain.com',
            //'bcc' => 'email3@domain.com',    
            'subject' => 'Nuova campionatura richiesta'
                ), $view);
    }

}
