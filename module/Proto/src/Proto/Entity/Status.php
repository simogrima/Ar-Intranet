<?php

namespace Proto\Entity;

use Doctrine\Common\Collections\ArrayCollection,
    Doctrine\Common\Collections\Collection,
    Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="proto_status")
 */
class Status
{

    const STATUS_TYPE_REQUIRED = 5; //Richiesta    
    const STATUS_TYPE_ESTIMATES_REQUESTED = 10; //Preventivi Richiesti
    const STATUS_TYPE_AWAITING_DETAILS = 15; //In attesa particolari
    const STATUS_TYPE_PROCESSING = 20; //In lavorazione
    const STATUS_TYPE_PAINTING = 25; //Verniciatura
    const STATUS_TYPE_FINAL_VERIFICATION = 30; //Verifica finale
    const STATUS_TYPE_DELIVERED = 35; //Consegnata    
    const STATUS_TYPE_CANCELED = 40; //Annullata


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
     * @return \Proto\Entity\Status
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
            case self::STATUS_TYPE_REQUIRED: //5
                return 'default';
                break;            
            case self::STATUS_TYPE_ESTIMATES_REQUESTED: //10
                return 'warning';
                break;
            case self::STATUS_TYPE_AWAITING_DETAILS: //15
                return 'warning';
                break;                          
            case self::STATUS_TYPE_DELIVERED: //35
                return 'success';
                break;         
            case self::STATUS_TYPE_CANCELED: //40
                return 'danger';
                break;            
            default: //20,25,30
                return 'info';
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
