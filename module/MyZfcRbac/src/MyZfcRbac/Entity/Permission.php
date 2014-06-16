<?php
namespace MyZfcRbac\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Rbac\Permission\PermissionInterface;

/**
 * @ORM\Entity
 * @ORM\Table(name="permissions")
 */
class Permission implements PermissionInterface
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
     * @ORM\Column(type="string", length=128, unique=true)
     */
    protected $name;
    
    /**
     * @var HierarchicalRoleInterface[]|\Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="FlatRole", mappedBy="permissions")
     */
    protected $roles;    
    
    /**
     * Init the Doctrine collection
     */
    public function __construct()
    {
        $this->roles    = new ArrayCollection();
    }    
    
    public function getRoles()
    {
        return $this->roles;
    }       
    

    /**
     * Constructor
    
    public function __construct($name)
    {
        $this->name  = (string) $name;
    } */

    /**
     * Get the permission identifier
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritDoc}
     */
    public function __toString()
    {
        return $this->name;
    }
    
    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }


}