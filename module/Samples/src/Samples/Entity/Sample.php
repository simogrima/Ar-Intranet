<?php
namespace Samples\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity
 * @ORM\Table(name="samples")
 */
class Sample
{
    /**
     * @var int|null
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @var string|null
     *
     * @ORM\Column(type="string", length=128)
     */
    protected $model;   
    
    /**
     * @var string|null
     *
     * @ORM\Column(type="string", length=128)
     */
    protected $voltage;//tensione
    
    /**
     * @var string|null
     *
     * @ORM\Column(type="string", length=128)
     */
    protected $plug;//spina
    
    /**
     * @var string|null
     *
     * @ORM\Column(type="string", length=128)
     */
    protected $frequency;//frequenza
    
    /**
     * @var string|null
     *
     * @ORM\Column(type="string", length=128)
     */
    protected $serigraphy;//serigrafia
    
    /**
     * @var string|null
     *
     * @ORM\Column(type="string", length=128)
     */
    protected $colors;//frequenza
    
    /**
     * @var string|null
     *
     * @ORM\Column(type="string", length=128)
     */
    protected $cable;//frequenza
    
    /**
     * @var string|null
     *
     * @ORM\Column(type="string", length=128)
     */
    protected $accessories;//accessori  
    
    
   /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_date", type="datetime", nullable=false)
     */
    private $createdDate;    
}