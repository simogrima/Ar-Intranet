<?php

namespace Proto\Entity;

use Doctrine\Common\Collections\ArrayCollection,
    Doctrine\Common\Collections\Collection,
    Doctrine\ORM\Mapping as ORM,
    \Proto\Entity\Status;

/**
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 * @ORM\Table(name="proto_history")
 */
class History
{

    /**
     * @var int|null
     *
     * @ORM\Id
     * @ORM\Column(name="id", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var \Proto\Entity\Proto
     *
     * @ORM\ManyToOne(targetEntity="Proto\Entity\Proto", inversedBy="history", cascade={"persist"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="proto_id", nullable=true, referencedColumnName="id")
     * })
     */
    protected $proto;



    /**
     * @var \Proto\Entity\Status
     *
     * @ORM\ManyToOne(targetEntity="Proto\Entity\Status", cascade={"persist"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="proto_status_id", nullable=true, referencedColumnName="id")
     * })
     */
    protected $protoStatus;

    /**
     * @var \User\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="User\Entity\User", cascade={"persist"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="edit_by", nullable=true, referencedColumnName="id")
     * })
     */
    protected $editBy;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="edit_date", type="datetime", nullable=false)
     */
    protected $editDate;

    /**
     * Get id
     * 
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set proto
     *
     * @param \Proto\Entity\Proto
     * @return \Proto\Entity\History
     */
    public function setProto(\Proto\Entity\Proto $proto = null)
    {
        $this->proto= $proto;

        return $this;
    }

    /**
     * Get proto
     *
     * @return \Proto\Entity\Proto
     */
    public function getProto()
    {
        return $this->proto;
    }


    /**
     * Set protoStatus
     *
     * @param \Proto\Entity\Status
     * @return \Proto\Entity\History
     */
    public function setProtoStatus(\Proto\Entity\Status $status = null)
    {
        $this->protoStatus = $status;

        return $this;
    }

    /**
     * Get protoStatus
     *
     * @return \Proto\Entity\Status 
     */
    public function getProtoStatus()
    {
        return $this->protoStatus;
    }

    /**
     * Set editBy
     *
     * @param \User\Entity\User
     * @return \Proto\Entity\History
     */
    public function setEditBy(\User\Entity\User $user = null)
    {
        $this->editBy = $user;

        return $this;
    }

    /**
     * Get editBy
     *
     * @return \User\Entity\User
     */
    public function getEditBy()
    {
        return $this->editBy;
    }

    /**
     * Get editDate
     * 
     * @return \DateTime 
     */
    public function getEditDate()
    {
        return $this->editDate;
    }

    /**
     * Set editDate
     * 
     * @param \DateTime $editDate
     * @return \Proto\Entity\History
     */
    public function setEditDate(\DateTime $editDate)
    {
        $this->editDate = $editDate;

        return $this;
    }

    /**
     * Metodo puramente logico.
     * In base al tipo ritorna una serie di attribuiti che mi serviranno nel front-end
     * @return array
     */
    public function getAttributes()
    {
        $result = [];

            switch ($this->getProtoStatus()->getId()) {
                case Status::STATUS_TYPE_REQUIRED: //5
                    $result['icon'] = 'fa-clock-o';
                    $result['class'] = 'default';
                    break;
                case Status::STATUS_TYPE_ESTIMATES_REQUESTED: //10
                    $result['icon'] = 'fa-mail-forward';
                    $result['class'] = 'warning';
                    break;
                case Status::STATUS_TYPE_AWAITING_DETAILS: //15
                    $result['icon'] = 'fa-hourglass-end';
                    $result['class'] = 'warning';
                    break;  
                case Status::STATUS_TYPE_PROCESSING: //20
                    $result['icon'] = 'fa-wrench';
                    $result['class'] = 'info';
                    break;    
                case Status::STATUS_TYPE_PAINTING: //25
                    $result['icon'] = 'fa-paint-brush';
                    $result['class'] = 'info';
                    break;                 
                case Status::STATUS_TYPE_FINAL_VERIFICATION: //30
                    $result['icon'] = 'fa-cogs';
                    $result['class'] = 'info';
                    break;                 
                case Status::STATUS_TYPE_DELIVERED: //35
                    $result['icon'] = 'fa-check';
                    $result['class'] = 'success';
                    break;      
                case Status::STATUS_TYPE_CANCELED: //25
                    $result['icon'] = 'fa-trash';
                    $result['class'] = 'danger';
                    break;                
                default:
                    break;
            }        

        return $result;
    }

    /**
     * @ORM\PrePersist
     */
    public function prePersist()
    {
        //$this->setEditDate(new \Datetime());
    }

}
