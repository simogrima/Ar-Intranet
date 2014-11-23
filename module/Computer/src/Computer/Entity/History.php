<?php

namespace Computer\Entity;

use Doctrine\Common\Collections\ArrayCollection,
    Doctrine\Common\Collections\Collection,
    Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 * @ORM\Table(name="computer_history")
 */
class History
{

    const HISTORY_TYPE_COMPUTER_CREATE = 1;
    const HISTORY_TYPE_COMPUTER_MODIFY = 2;
    const HISTORY_TYPE_COMPUTER_CHAGE_RECIPIENT = 3;
    const HISTORY_TYPE_COMPUTER_CHAGE_STATUS = 4;

    /**
     * @var int|null
     *
     * @ORM\Id
     * @ORM\Column(name="id", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var \Computer\Entity\Computer
     *
     * @ORM\ManyToOne(targetEntity="Computer\Entity\Computer", inversedBy="history", cascade={"persist"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="computer_id", nullable=true, referencedColumnName="id")
     * })
     */
    protected $computer;

    /**
     * @var \User\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="User\Entity\User", cascade={"persist"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="recipient", nullable=true, referencedColumnName="id")
     * })
     */
    protected $recipient;

    /**
     * @var int
     *
     * @ORM\Column(type="smallint", options={"unsigned"=true, "default" = 0})
     */
    protected $type;

    /**
     * @var int
     *
     * @ORM\Column(type="smallint", options={"unsigned"=true, "default" = 0})
     */
    protected $status;

    /**
     * @var \Computer\Entity\Status
     *
     * @ORM\ManyToOne(targetEntity="Computer\Entity\Status", cascade={"persist"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="computer_status_id", nullable=true, referencedColumnName="id")
     * })
     */
    protected $computerStatus;

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
     * Set computer
     *
     * @param \Computer\Entity\Computer
     * @return \Computer\Entity\History
     */
    public function setComputer(\Computer\Entity\Computer $computer = null)
    {
        $this->computer = $computer;

        return $this;
    }

    /**
     * Get computer
     *
     * @return \Computer\Entity\Computer
     */
    public function getComputer()
    {
        return $this->computer;
    }

    /**
     * Set recipient
     *
     * @param \User\Entity\User
     * @return \Computer\Entity\History
     */
    public function setRecipient(\User\Entity\User $user = null)
    {
        $this->recipient = $user;

        return $this;
    }

    /**
     * Get recipient
     *
     * @return \User\Entity\User
     */
    public function getRecipient()
    {
        return $this->recipient;
    }

    /**
     * Get type
     * 
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set type
     * 
     * @param string $type
     * @return \Computer\Entity\History
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get status
     * 
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set status
     * 
     * @param string $status
     * @return \Computer\Entity\History
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Set computerStatus
     *
     * @param \Computer\Entity\Status
     * @return \Computer\Entity\History
     */
    public function setComputerStatus(\Computer\Entity\Status $status = null)
    {
        $this->computerStatus = $status;

        return $this;
    }

    /**
     * Get computerstatus
     *
     * @return \Computer\Entity\Status 
     */
    public function getComputerStatus()
    {
        return $this->computerStatus;
    }

    /**
     * Set editBy
     *
     * @param \User\Entity\User
     * @return \Computer\Entity\History
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
     * @return \Computer\Entity\Computer
     */
    public function setEditdDate(\DateTime $createdDate)
    {
        $this->editDate = $createdDate;

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

        if ($this->getType() == self::HISTORY_TYPE_COMPUTER_CHAGE_STATUS) {
            $result['action'] = 'Cambio Stato';
            $result['description'] = 'Il computer è passato nello stato: ' . $this->getComputerStatus()->getName();
            switch ($this->getComputerStatus()->getId()) {
                case 1:
                    $result['icon'] = 'fa-check';
                    $result['class'] = 'success';
                    break;
                case 2:
                    $result['icon'] = 'fa-database';
                    $result['class'] = 'warning';
                    break;
                case 3:
                    $result['icon'] = 'fa-trash';
                    $result['class'] = 'danger';
                    break;
                default:
                    break;
            }
        } else {
            switch ($this->getType()) {
                case self::HISTORY_TYPE_COMPUTER_CREATE:
                    $result['action'] = 'Creazione';
                    $result['icon'] = 'fa-save';
                    $result['class'] = '';
                    $result['description'] = 'Aggiunto nuovo computer';
                    break;
                case self::HISTORY_TYPE_COMPUTER_MODIFY:
                    $result['action'] = 'Modifica';
                    $result['icon'] = 'fa-edit';
                    $result['class'] = '';
                    $result['description'] = 'Il computer è stato modificato';
                    break;
                case self::HISTORY_TYPE_COMPUTER_CHAGE_RECIPIENT:
                    $result['action'] = 'Assegnazione';
                    $result['icon'] = 'fa-user';
                    $result['class'] = 'info';
                    $result['description'] = 'Il computer è stato assegnato a ' . $this->getRecipient()->getDisplayName();
                    break;
                default:
                    break;
            }
        }


        return $result;
    }

    /**
     * @ORM\PrePersist
     */
    public function prePersist()
    {
        $this->setStatus(1);
        $this->setEditdDate(new \Datetime());
    }

}
