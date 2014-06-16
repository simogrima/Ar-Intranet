<?php
namespace MyZfcRbac\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Rbac\Permission\PermissionInterface;
use Rbac\Role\RoleInterface;

/**
 * @ORM\Entity
 * @ORM\Table(name="roles")
 */
class FlatRole implements RoleInterface
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
     * @ORM\Column(type="string", length=48, unique=true)
     */
    protected $name;
    
    /**
     * @var PermissionInterface[]|\Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Permission", indexBy="name", fetch="EAGER", inversedBy="roles")
     * @ORM\JoinTable(name="flatrole_permission")
     */
    protected $permissions;

    /**
     * Init the Doctrine collection
     */
    public function __construct()
    {
        $this->permissions = new ArrayCollection();
    }

    /**
     * Get the role identifier
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the role name
     *
     * @param  string $name
     * @return void
     */
    public function setName($name)
    {
        $this->name = (string) $name;
    }

    /**
     * Get the role name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * {@inheritDoc}
     */
    public function addPermission($permission)
    {
        if (is_string($permission)) {
            $permission = new Permission($permission);
        }

        $this->permissions[(string) $permission] = $permission;
    }

    /**
     * {@inheritDoc}
     */
    public function hasPermission($permission)
    {
        // This can be a performance problem if your role has a lot of permissions. Please refer
        // to the cookbook to an elegant way to solve this issue

        return isset($this->permissions[(string) $permission]);
    }
    
    public function getPermissions()
    {
        return $this->permissions;
    }      
       
   // form doctrine hydrator 
   public function addPermissions(Collection $permissions)
    {
        foreach ($permissions as $permission) {
            $this->permissions->add($permission);
        }
    }

    // for doctrine hydrator
    public function removePermissions(Collection $permissions)
    {
        foreach ($permissions as $permission) {
            $this->permissions->removeElement($permission);
        }
    }    
    
   public function setPermissions(Collection $permissions)
    {
        $this->permissions = $permissions;
    }        
}