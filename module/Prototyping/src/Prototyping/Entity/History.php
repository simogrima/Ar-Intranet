<?php

namespace Prototyping\Entity;

use Doctrine\Common\Collections\ArrayCollection,
    Doctrine\Common\Collections\Collection,
    Doctrine\ORM\Mapping as ORM,
    \Prototyping\Entity\Status;

/**
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 * @ORM\Table(name="prototyping_history")
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
     * @var \Prototyping\Entity\Prototyping
     *
     * @ORM\ManyToOne(targetEntity="Prototyping\Entity\Prototyping", inversedBy="history", cascade={"persist"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="prototyping_id", nullable=true, referencedColumnName="id")
     * })
     */
    protected $prototyping;



    /**
     * @var \Prototyping\Entity\Status
     *
     * @ORM\ManyToOne(targetEntity="Prototyping\Entity\Status", cascade={"persist"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="prototyping_status_id", nullable=true, referencedColumnName="id")
     * })
     */
    protected $prototypingStatus;

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
     * Set prototyping
     *
     * @param \Prototyping\Entity\Prototyping
     * @return \Prototyping\Entity\History
     */
    public function setPrototyping(\Prototyping\Entity\Prototyping $prototyping = null)
    {
        $this->prototyping = $prototyping;

        return $this;
    }

    /**
     * Get prototyping
     *
     * @return \Prototyping\Entity\Prototyping
     */
    public function getPrototyping()
    {
        return $this->prototyping;
    }


    /**
     * Set prototypingStatus
     *
     * @param \Prototyping\Entity\Status
     * @return \Prototyping\Entity\History
     */
    public function setPrototypingStatus(\Prototyping\Entity\Status $status = null)
    {
        $this->prototypingStatus = $status;

        return $this;
    }

    /**
     * Get prototypingStatus
     *
     * @return \Prototyping\Entity\Status 
     */
    public function getPrototypingStatus()
    {
        return $this->prototypingStatus;
    }

    /**
     * Set editBy
     *
     * @param \User\Entity\User
     * @return \Prototyping\Entity\History
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
     * @return \Prototyping\Entity\History
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

            switch ($this->getPrototypingStatus()->getId()) {
                case Status::STATUS_TYPE_REQUIRED: //5
                    $result['icon'] = 'fa-clock-o';
                    $result['class'] = 'default';
                    break;
                case Status::STATUS_TYPE_IN_PROGRESS: //10
                    $result['icon'] = 'fa-mail-forward';
                    $result['class'] = 'warning';
                    break;
                case Status::STATUS_TYPE_CLOSED: //15
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
