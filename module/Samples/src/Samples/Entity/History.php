<?php

namespace Samples\Entity;

use Doctrine\Common\Collections\ArrayCollection,
    Doctrine\Common\Collections\Collection,
    Doctrine\ORM\Mapping as ORM,
    \Samples\Entity\Status;

/**
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 * @ORM\Table(name="samples_history")
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
     * @var \Samples\Entity\Sample
     *
     * @ORM\ManyToOne(targetEntity="Samples\Entity\Sample", inversedBy="history", cascade={"persist"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="sample_id", nullable=true, referencedColumnName="id")
     * })
     */
    protected $sample;



    /**
     * @var \Samples\Entity\Status
     *
     * @ORM\ManyToOne(targetEntity="Samples\Entity\Status", cascade={"persist"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="samples_status_id", nullable=true, referencedColumnName="id")
     * })
     */
    protected $sampleStatus;

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
     * Set sample
     *
     * @param \Samples\Entity\Sample
     * @return \Samples\Entity\History
     */
    public function setSample(\Samples\Entity\Sample $sample = null)
    {
        $this->sample = $sample;

        return $this;
    }

    /**
     * Get sample
     *
     * @return \Samples\Entity\Sample
     */
    public function getSample()
    {
        return $this->sample;
    }


    /**
     * Set sampleStatus
     *
     * @param \Samples\Entity\Status
     * @return \Samples\Entity\History
     */
    public function setSampleStatus(\Samples\Entity\Status $status = null)
    {
        $this->sampleStatus = $status;

        return $this;
    }

    /**
     * Get sampleStatus
     *
     * @return \Sample\Entity\Status 
     */
    public function getSampleStatus()
    {
        return $this->sampleStatus;
    }

    /**
     * Set editBy
     *
     * @param \User\Entity\User
     * @return \Samples\Entity\History
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
     * @return \CSamples\Entity\History
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

            switch ($this->getSampleStatus()->getId()) {
                case Status::STATUS_TYPE_PENDING_EVASION: //1
                    $result['icon'] = 'fa-clock-o';
                    $result['class'] = 'default';
                    break;
                case Status::STATUS_TYPE_PRODUCT_REQUIRED: //5
                    $result['icon'] = 'fa-mail-forward';
                    $result['class'] = 'warning';
                    break;
                case Status::STATUS_TYPE_PRODUCT_ARRIVED: //10
                    $result['icon'] = 'fa-mail-reply';
                    $result['class'] = 'info';
                    break;
                case Status::STATUS_TYPE_PROCESSED: //15
                    $result['icon'] = 'fa-check';
                    $result['class'] = 'success';
                    break;      
                case Status::STATUS_TYPE_SHIPPED: //20
                    $result['icon'] = 'fa-plane';
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
