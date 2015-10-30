<?php

namespace Prototyping\Entity;

use Doctrine\Common\Collections\ArrayCollection,
    Doctrine\Common\Collections\Collection,
    Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="prototyping_status")
 */
class Status
{
    const STATUS_TYPE_REQUIRED = 5; //Richiesta    
    const STATUS_TYPE_IN_PROGRESS = 10; //In corso
    const STATUS_TYPE_CLOSED = 15; //Chiusa
    const STATUS_TYPE_CANCELED = 25; //Annullata

    /**
     * @var int|null
     *
     * @ORM\Id
     * @ORM\Column(name="id", type="integer")
     */
    protected $id;

    /**
     * @var string|null
     *
     * @ORM\Column(type="string", length=64)
     */
    protected $name;

    
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
     * Set id
     * 
     * @param string $name
     * @return \Prototyping\Entity\Status
     */
    public function setId($id)
    {
        $this->id = $id;
        
        return $this;
    }    

    /**
     * Get name
     * 
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set name
     * 
     * @param string $name
     * @return \Computer\Entity\Status
     */
    public function setName($name)
    {
        $this->name = $name;
        
        return $this;
    }
    
    public static function getCssClass($id)
    {
        switch ($id) {
            case self::STATUS_TYPE_IN_PROGRESS:
                return 'warning';
                break;
            case self::STATUS_TYPE_CLOSED:
                return 'success';
                break;         
            case self::STATUS_TYPE_CANCELED:
                return 'danger';
                break;            
            default: //1
                return 'default';
                break;
        }
    }      
    
    static private $statusTypeValues = null;
    static public function getStatusTypeValues()
    {
    	if (self::$statusTypeValues == null) {
    		self::$statusTypeValues = array();
    		$oClass = new \ReflectionClass(__NAMESPACE__ . '\Status');
    		$classConstants = $oClass->getConstants();
    		$constantPrefix = "STATUS_TYPE_";
    		foreach ($classConstants as $key => $val) {
    			if (substr($key, 0, strlen($constantPrefix)) === $constantPrefix) {
    				self::$statusTypeValues[$val] = $val;
    			}
    		}
    	}
    	return self::$statusTypeValues;
    }    

}
