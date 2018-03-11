<?php

namespace ToG\RolePlayBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use JsonSerializable;

/**
 * Group
 *
 * @ORM\Table(name="tog_group")
 * @ORM\Entity(repositoryClass="ToG\RolePlayBundle\Repository\GroupRepository")
 */
class Group implements JsonSerializable
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, unique=true)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="abreviation", type="string", length=255, unique=true)
     */
    private $abreviation;

    /**
     * @var string
     *
     * @ORM\Column(name="colour", type="string", length=6, nullable=true)
     */
    private $colour;

    /**
     * @var array
     *
     * @ORM\Column(name="roles", type="array")
     */
    private $roles = array();

    /**
     * @var int
     *
     * @ORM\Column(name="is_not_rp", type="integer")
     */
    private $is_not_rp; // 0 = groupe RP, 1 = groupe HRP

    /**
     * @ORM\OneToMany(targetEntity="UserGroupAssociation", mappedBy="group")
     */
    protected $user_group_associations;

    /**
     * @ORM\OneToMany(targetEntity="\ToG\RolePlayBundle\Entity\Character", mappedBy="group", fetch="EAGER")
     */
    protected $characters;

    /**
     * @ORM\OneToMany(targetEntity="\ToG\UserBundle\Entity\User", mappedBy="activeGroup")
     *
     * Un utilisateur peut avoir plusieurs groupes, mais il n'y en a qu'un qui est considéré "actif"
     */
    protected $activeUsers;

    /**
     * Correspond à tous les membres du groupe, qu'ils soient User ou Character
     *
     * @var array
     */
    protected $members;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->user_group_associations = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add characters
     *
     * @param Character $character
     *
     * @return self
     */
    public function addCharacter(\ToG\RolePlayBundle\Entity\Character $character)
    {
        $this->characters[] = $character;

        return $this;
    }

    /**
     * Remove characters
     *
     * @param Character $character
     */
    public function removeCharacter(\ToG\RolePlayBundle\Entity\Character $character)
    {
        $this->characters->removeElement($character);
    }

    /**
     * Get characters
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCharacters()
    {
        return $this->characters;
    }

    /**
     * Add user_group_associations
     *
     * @param \ToG\RolePlayBundle\Entity\UserGroupAssociation $user_group_associations
     * @return Group
     */
    public function addUserGroupAssociation(\ToG\RolePlayBundle\Entity\UserGroupAssociation $user_group_associations)
    {
        $this->user_group_associations[] = $user_group_associations;

        return $this;
    }

    /**
     * Remove user_group_associations
     *
     * @param \ToG\RolePlayBundle\Entity\UserGroupAssociation $user_group_associations
     */
    public function removeUserGroupAssociation(\ToG\RolePlayBundle\Entity\UserGroupAssociation $user_group_associations)
    {
        $this->user_group_associations->removeElement($user_group_associations);
    }

    /**
     * Get user_group_associations
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUserGroupAssociations()
    {
        return $this->user_group_associations;
    }

    /**
     * Get the value of Id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of Id
     *
     * @param int id
     *
     * @return self
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of Name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the value of Name
     *
     * @param string name
     *
     * @return self
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get the value of Abreviation
     *
     * @return string
     */
    public function getAbreviation()
    {
        return $this->abreviation;
    }

    /**
     * Set the value of Abreviation
     *
     * @param string abreviation
     *
     * @return self
     */
    public function setAbreviation($abreviation)
    {
        $this->abreviation = $abreviation;

        return $this;
    }

    /**
     * Get the value of Colour
     *
     * @return string
     */
    public function getColour()
    {
        return $this->colour;
    }

    /**
     * Set the value of Colour
     *
     * @param string colour
     *
     * @return self
     */
    public function setColour($colour)
    {
        $this->colour = $colour;

        return $this;
    }

    /**
     * Get the value of Roles
     *
     * @return array
     */
    public function getRoles()
    {
        return $this->roles;
    }

    /**
     * Set the value of Roles
     *
     * @param array roles
     *
     * @return self
     */
    public function setRoles(array $roles)
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * Get the value of Is Not Rp
     *
     * @return int
     */
    public function getIsNotRp()
    {
        return $this->is_not_rp;
    }

    /**
     * Set the value of Is Not Rp
     *
     * @param int is_not_rp
     *
     * @return self
     */
    public function setIsNotRp($is_not_rp)
    {
        $this->is_not_rp = $is_not_rp;

        return $this;
    }

    /**
     * Add activeUsers
     *
     * @param \ToG\UserBundle\Entity\User $activeUser
     *
     * @return self
     */
    public function addActiveUser(\ToG\UserBundle\Entity\User $activeUser)
    {
        $this->activeUsers[] = $activeUser;

        return $this;
    }

    /**
     * Remove activeUsers
     *
     * @param \ToG\UserBundle\Entity\User $activeUser
     */
    public function removeActiveUser(\ToG\UserBundle\Entity\User $activeUser)
    {
        $this->activeUsers->removeElement($activeUser);
    }

    /**
     * Get activeUsers
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getActiveUsers()
    {
        return $this->activeUsers;
    }

    /**
     * Get the value of Members
     *
     * @return array
     */
    public function getMembers()
    {
        return $this->members;
    }

    /**
     * Set the value of Members
     *
     * @param array members
     *
     * @return self
     */
    public function setMembers(array $members)
    {
        $this->members = $members;

        return $this;
    }

    public function jsonSerialize()
    {
        return array(
            'id'     => $this->id,
            'name'   => $this->name,
            'colour' => $this->colour,
            'abreviation' => $this->abreviation
        );
    }
}
