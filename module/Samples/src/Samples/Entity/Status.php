<?php

namespace Samples\Entity;

use Doctrine\Common\Collections\ArrayCollection,
    Doctrine\Common\Collections\Collection,
    Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="samples_status")
 */
class Status
{
    const STATUS_TYPE_PENDING_EVASION = 1; //In attesa di avasione
    const STATUS_TYPE_PRODUCT_REQUIRED = 5; //Prodotto richiesto    
    const STATUS_TYPE_PRODUCT_ARRIVED = 10; //Prodotto richiesto
    const STATUS_TYPE_PROCESSED = 15; //Evasa
    const STATUS_TYPE_SHIPPED = 20; //Spedita
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
     * @return \Samples\Entity\Status
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
            case self::STATUS_TYPE_PRODUCT_REQUIRED:
                return 'warning';
                break;
            case self::STATUS_TYPE_PRODUCT_ARRIVED:
                return 'info';
                break;
            case self::STATUS_TYPE_PROCESSED:
            case self::STATUS_TYPE_SHIPPED:
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
