<?php

namespace ToG\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * User
 *
 * @ORM\Table(name="tog_user")
 * @ORM\Entity(repositoryClass="ToG\UserBundle\Repository\UserRepository")
 * @UniqueEntity(fields="email", message="Cette adresse email est déjà prise")
 * @UniqueEntity(fields="username", message="Ce nom d'utilisateur est déjà pris")
 */
class User implements UserInterface, \Serializable
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
     * @ORM\Column(name="username", type="string", length=255, unique=true)
     */
    private $username;

    /**
     * @var string
     *
     * @ORM\Column(name="colour", type="string", length=6, nullable=true)
     */
    private $colour;

    /**
     * @Assert\Length(max=4096)
     */
    private $plainPassword; // à la création du compte

    /**
     * @Assert\Length(max=4096)
     */
    private $newPlainPassword; // lorsque l'on souhaite modifier son compte

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=64)
     */
    private $password;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, unique=true)
     */
    private $email;

    /**
     * @var array
     *
     * @ORM\Column(name="roles", type="array")
     */
    private $roles = array();

    /**
     * @var int
     *
     * @ORM\Column(name="register_date", type="datetime")
     */
    private $registerDate;

    /**
     * @var int
     *
     * @ORM\Column(name="last_login", type="datetime")
     */
    private $lastLogin;

    /**
     * @var int
     *
     * @ORM\Column(name="last_activity", type="datetime")
     */
    private $lastActivity;

    /**
     * @var string
     *
     * @ORM\Column(name="avatar", type="string", length=255, nullable=true)
     *
     * @Assert\Image(
     *     minWidth = 150,
     *     minHeight = 150,
     *     maxWidth = 150,
     *     maxHeight = 150
     * )
     */
    private $avatar;

    /**
     * @ORM\OneToMany(targetEntity="\ToG\RolePlayBundle\Entity\UserGroupAssociation", mappedBy="user")
     */
    protected $user_group_associations;

    /**
     * @ORM\ManyToOne(targetEntity="\ToG\RolePlayBundle\Entity\Group", inversedBy="activeUsers")
     * @ORM\JoinColumn(name="active_group_id", referencedColumnName="id")
     *
     * Un utilisateur peut avoir plusieurs groupes, mais il n'y en a qu'un qui est considéré "actif"
     */
    protected $activeGroup;

    /**
     * @ORM\OneToMany(targetEntity="\ToG\RolePlayBundle\Entity\Character", mappedBy="user", fetch="EAGER")
     */
    protected $characters;

    /**
     * @ORM\OneToMany(targetEntity="\ToG\ForumBundle\Entity\Post", mappedBy="user", fetch="EAGER")
     */
    protected $posts;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->user_group_associations = new \Doctrine\Common\Collections\ArrayCollection();
    }

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
     * Set username
     *
     * @param string $username
     *
     * @return User
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set plainPassword
     *
     * @param string $plainPassword
     *
     * @return User
     */
    public function setPlainPassword($plainPassword)
    {
        $this->plainPassword = $plainPassword;

        return $this;
    }

    /**
     * Get plainPassword
     *
     * @return string
     */
    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    /**
     * Set newPlainPassword
     *
     * @param string $newPlainPassword
     *
     * @return User
     */
    public function setNewPlainPassword($newPlainPassword)
    {
        $this->newPlainPassword = $newPlainPassword;

        return $this;
    }

    /**
     * Get newPlainPassword
     *
     * @return string
     */
    public function getNewPlainPassword()
    {
        return $this->newPlainPassword;
    }

    /**
     * Set password
     *
     * @param string $password
     *
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return User
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Get salt
     *
     * @return string
     */
    public function getSalt()
    {
        return null;
    }

    /**
     * Set roles
     *
     * @param array $roles
     *
     * @return User
     */
    public function setRoles($roles)
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * Get roles
     *
     * @return array
     */
    public function getRoles()
    {
        return $this->roles;
    }

    public function eraseCredentials()
    {
    }

    /**
     * Set registerDate
     *
     * @param \DateTime $registerDate
     *
     * @return User
     */
    public function setRegisterDate(\DateTime $registerDate)
    {
        $this->registerDate = $registerDate;

        return $this;
    }

    /**
     * Get registerDate
     *
     * @return \DateTime
     */
    public function getRegisterDate()
    {
        return $this->registerDate;
    }

    /**
     * Set lastLogin
     *
     * @param \DateTime $lastLogin
     *
     * @return User
     */
    public function setLastLogin($lastLogin)
    {
        $this->lastLogin = clone $lastLogin;

        return $this;
    }

    /**
     * Get lastLogin
     *
     * @return \DateTime
     */
    public function getLastLogin()
    {
        return clone $this->lastLogin;
    }

    /**
     * Set lastActivity
     *
     * @param \DateTime $lastActivity
     *
     * @return User
     */
    public function setLastActivity($lastActivity)
    {
        $this->lastActivity = clone $lastActivity;

        return $this;
    }

    /**
     * Get lastActivity
     *
     * @return \DateTime
     */
    public function getLastActivity()
    {
        return clone $this->lastActivity;
    }

    /**
     * Set colour
     *
     * @param string $colour
     *
     * @return User
     */
    public function setColour($colour)
    {
        $this->colour = $colour;

        return $this;
    }

    /**
     * Get colour
     *
     * @return string
     */
    public function getColour()
    {
        return $this->colour;
    }

    /**
     * Set avatar
     *
     * @param string $avatar
     *
     * @return User
     */
    public function setAvatar($avatar)
    {
        $this->avatar = $avatar;

        return $this;
    }

    /**
     * Get avatar
     *
     * @return string
     */
    public function getAvatar()
    {
        return $this->avatar;
    }

    /**
     * Add user_group_associations
     *
     * @param \ToG\RolePlayBundle\Entity\UserGroupAssociation $user_group_associations
     * @return User
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
     * Add post
     *
     * @param \ToG\ForumBundle\Entity\Post $post
     * @return User
     */
    public function addPost(\ToG\ForumBundle\Entity\Post $post)
    {
        $this->posts[] = $post;

        return $this;
    }

    /**
     * Remove post
     *
     * @param \ToG\ForumBundle\Entity\Post $post
     */
    public function removePost(\ToG\ForumBundle\Entity\Post $post)
    {
        $this->posts->removeElement($post);
    }

    /**
     * Get posts
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPosts()
    {
        return $this->posts;
    }


    /**
     * Add character
     *
     * @param \ToG\RolePlayBundle\Entity\Character $character
     * @return User
     */
    public function addCharacter(\ToG\RolePlayBundle\Entity\Character $character)
    {
        $this->characters[] = $character;

        return $this;
    }

    /**
     * Remove character
     *
     * @param \ToG\RolePlayBundle\Entity\Character $character
     */
    public function removeCharacters(\ToG\RolePlayBundle\Entity\Character $character)
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
     * Get the value of Characters Count
     *
     * @return int
     */
    // public function getCharactersCount()
    // {
    //     return $this->characters_count;
    // }

    /**
     * Set activeGroup
     *
     * @param \ToG\RolePlayBundle\Entity\Group $activeGroup
     *
     * @return Post
     */
    public function setGroup(\ToG\RolePlayBundle\Entity\Group $activeGroup = null)
    {
        $this->activeGroup = $activeGroup;

        return $this;
    }

    /**
     * Get activeGroup
     *
     * @return \ToG\RolePlayBundle\Entity\Group
     */
    public function getGroup()
    {
        return $this->activeGroup;
    }

    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->username,
            $this->password,
            $this->colour,
            $this->email,
            $this->roles,
            $this->registerDate,
            $this->lastLogin,
            $this->lastActivity
        ));
    }

    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->username,
            $this->password,
            $this->colour,
            $this->email,
            $this->roles,
            $this->registerDate,
            $this->lastLogin,
            $this->lastActivity
        ) = unserialize($serialized);
    }
}
