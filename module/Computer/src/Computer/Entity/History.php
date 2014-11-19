<?php

namespace Computer\Entity;

use Doctrine\Common\Collections\ArrayCollection,
    Doctrine\Common\Collections\Collection,
    Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="computer_history")
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

        if ($this->getType() == 4) {
            $status = $this->getComputer()->getStatus();
            $result['action'] = 'Cambiato';
            $result['description'] = 'Il computer è passato nello stato: ' . $status->getName();   
            switch ($status->getId()) {
                case 1:
                    $result['icon'] = 'fa-check';
                    $result['class'] = 'green';
                    break;
                case 2:
                    $result['icon'] = 'fa-database';
                    $result['class'] = 'yellow';
                    break;
                    $result['icon'] = 'fa-trash';
                    $result['class'] = 'red';
                    break;
                default:
                    break;                
            }
        } else {
            switch ($this->getType()) {
                case 1:
                    $result['action'] = 'Creazione';
                    $result['icon'] = 'fa-save';
                    $result['class'] = '';
                    $result['description'] = 'Aggiunto nuovo computer';
                    break;
                case 2:
                    $result['action'] = 'Modifica';
                    $result['icon'] = 'fa-edit';
                    $result['class'] = '';
                    $result['description'] = 'Il computer è stato modificato';
                    break;
                case 3:
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

}
