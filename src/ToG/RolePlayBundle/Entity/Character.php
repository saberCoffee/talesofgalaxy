<?php

namespace ToG\RolePlayBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Character
 *
 * @ORM\Table(name="tog_character")
 * @ORM\Entity(repositoryClass="ToG\RolePlayBundle\Repository\CharacterRepository")
 */
class Character
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
      * @ORM\ManyToOne(targetEntity="\ToG\UserBundle\Entity\User", inversedBy="characters", fetch="EAGER")
      * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    protected $user;

    /**
      * @ORM\ManyToOne(targetEntity="\ToG\RolePlayBundle\Entity\Group", inversedBy="characters")
      * @ORM\JoinColumn(name="group_id", referencedColumnName="id")
     */
    protected $group;

    /**
     * @ORM\OneToMany(targetEntity="\ToG\ForumBundle\Entity\Post", mappedBy="character")
     */
    protected $posts;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, unique=true)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="firstname", type="string", length=255)
     */
    private $firstname;

    /**
     * @var string
     *
     * @ORM\Column(name="lastname", type="string", length=255)
     */
    private $lastname;

    /**
     * @var string
     *
     * @ORM\Column(name="surname", type="string", length=255, nullable=true)
     */
    private $surname;

    /**
     * @var string
     *
     * @ORM\Column(name="gender", type="string", length=1, nullable=true)
     */
    private $gender;

    /**
     * @var string
     *
     * @ORM\Column(name="species", type="string", length=255, nullable=true)
     */
    private $species;

    /**
     * @var int
     *
     * @ORM\Column(name="birthdate", type="integer", nullable=true)
     */
    private $birthdate;

    /**
     * @var string
     *
     * @ORM\Column(name="homeworld", type="string", length=255, nullable=true)
     */
    private $homeworld;

    /**
     * @var string
     *
     * @ORM\Column(name="rank", type="string", length=255, nullable=true)
     */
    private $rank;

    /**
     * @var string
     *
     * @ORM\Column(name="quote", type="string", length=255, nullable=true)
     */
    private $quote;

    /**
     * @var string
     *
     * @ORM\Column(name="alignment", type="string", length=255, nullable=true)
     */
    private $alignment;

    /**
     * @var int
     *
     * @ORM\Column(name="level", type="integer")
     */
    private $level;

    /**
     * @var string
     *
     * @ORM\Column(name="physical", type="text")
     */
    private $physical;

    /**
     * @var string
     *
     * @ORM\Column(name="mental", type="text")
     */
    private $mental;

    /**
     * @var int
     *
     * @ORM\Column(name="current_health", type="integer", nullable=true)
     */
    private $currentHealth;

    /**
     * @var int
     *
     * @ORM\Column(name="credits", type="integer", nullable=true)
     */
    private $credits;

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
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set user
     *
     * @param \stdClass $user
     *
     * @return Character
     */
    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \stdClass
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Add post
     *
     * @param \ToG\ForumBundle\Entity\Post $post
     *
     * @return Topic
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
     * Set name
     *
     * @param string $name
     *
     * @return Character
     */
    public function setName($name)
    {
        $this->name = $name;

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
     * Set firstname
     *
     * @param string $firstname
     *
     * @return Character
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Get firstName
     *
     * @return string
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Set lastname
     *
     * @param string $lastname
     *
     * @return Character
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * Get lastname
     *
     * @return string
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * Set surname
     *
     * @param string $surname
     *
     * @return Character
     */
    public function setSurname($surname)
    {
        $this->surname = $surname;

        return $this;
    }

    /**
     * Get surname
     *
     * @return string
     */
    public function getSurname()
    {
        return $this->surname;
    }

    /**
     * Set gender
     *
     * @param string $gender
     *
     * @return Character
     */
    public function setGender($gender)
    {
        $this->gender = $gender;

        return $this;
    }

    /**
     * Get gender
     *
     * @return string
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * Set species
     *
     * @param string $species
     *
     * @return Character
     */
    public function setSpecies($species)
    {
        $this->species = $species;

        return $this;
    }

    /**
     * Get species
     *
     * @return string
     */
    public function getSpecies()
    {
        return $this->species;
    }

    /**
     * Set birthdate
     *
     * @param integer $birthdate
     *
     * @return Character
     */
    public function setBirthdate($birthdate)
    {
        $this->birthdate = $birthdate;

        return $this;
    }

    /**
     * Get birthdate
     *
     * @return int
     */
    public function getBirthdate()
    {
        return $this->birthdate;
    }

    /**
     * Set homeworld
     *
     * @param string $homeworld
     *
     * @return Character
     */
    public function setHomeworld($homeworld)
    {
        $this->homeworld = $homeworld;

        return $this;
    }

    /**
     * Get homeworld
     *
     * @return string
     */
    public function getHomeworld()
    {
        return $this->homeworld;
    }

    /**
     * Set rank
     *
     * @param string $rank
     *
     * @return Character
     */
    public function setRank($rank)
    {
        $this->rank = $rank;

        return $this;
    }

    /**
     * Get rank
     *
     * @return string
     */
    public function getRank()
    {
        return $this->rank;
    }

    /**
     * Set quote
     *
     * @param string $quote
     *
     * @return Character
     */
    public function setQuote($quote)
    {
        $this->quote = $quote;

        return $this;
    }

    /**
     * Get quote
     *
     * @return string
     */
    public function getQuote()
    {
        return $this->quote;
    }

    /**
     * Set alignment
     *
     * @param string $alignment
     *
     * @return Character
     */
    public function setAlignment($alignment)
    {
        $this->alignment = $alignment;

        return $this;
    }

    /**
     * Get alignment
     *
     * @return string
     */
    public function getAlignment()
    {
        return $this->alignment;
    }

    /**
     * Set level
     *
     * @param integer $level
     *
     * @return Character
     */
    public function setLevel($level)
    {
        $this->level = $level;

        return $this;
    }

    /**
     * Get level
     *
     * @return int
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * Set physical
     *
     * @param string $physical
     *
     * @return self
     */
    public function setPhysical($physical)
    {
        $this->physical = $physical;

        return $this;
    }

    /**
     * Get physical
     *
     * @return string
     */
    public function getPhysical()
    {
        return $this->physical;
    }

    /**
     * Set mental
     *
     * @param string $mental
     *
     * @return self
     */
    public function setMental($mental)
    {
        $this->mental = $mental;

        return $this;
    }

    /**
     * Get mental
     *
     * @return string
     */
    public function getMental()
    {
        return $this->mental;
    }

    /**
     * Set currentHealth
     *
     * @param integer $currentHealth
     *
     * @return Character
     */
    public function setCurrentHealth($currentHealth)
    {
        $this->currentHealth = $currentHealth;

        return $this;
    }

    /**
     * Get currentHealth
     *
     * @return int
     */
    public function getCurrentHealth()
    {
        return $this->currentHealth;
    }

    /**
     * Set credits
     *
     * @param integer $credits
     *
     * @return Character
     */
    public function setCredits($credits)
    {
        $this->credits = $credits;

        return $this;
    }

    /**
     * Get credits
     *
     * @return int
     */
    public function getCredits()
    {
        return $this->credits;
    }

    /**
     * Set avatar
     *
     * @param string $avatar
     *
     * @return Character
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
     * Get the value of Group
     *
     * @return mixed
     */
    public function getGroup()
    {
        return $this->group;
    }

    /**
     * Set the value of Group
     *
     * @param mixed group
     *
     * @return self
     */
    public function setGroup($group)
    {
        $this->group = $group;

        return $this;
    }
}
