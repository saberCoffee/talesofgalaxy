<?php

namespace ToG\ForumBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use ToG\ForumBundle\Utility\Utility;

/**
 * Topic
 *
 * @ORM\Table(name="tog_topic")
 * @ORM\Entity(repositoryClass="ToG\ForumBundle\Repository\TopicRepository")
 */
class Topic
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
     * @ORM\ManyToOne(targetEntity="Forum", inversedBy="topics")
     * @ORM\JoinColumn(name="forum_id", referencedColumnName="id")
     */
    protected $forum;

    /**
     * @ORM\OneToMany(targetEntity="Post", mappedBy="topic")
     */
    protected $posts;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var int
     *
     * @ORM\Column(name="type", type="smallint")
     */
    private $type; // type 0 = topic, 1 = postit, 2 = annonce

    /**
     * @var int
     *
     * @ORM\Column(name="status", type="smallint")
     */
    private $status; // status 0 = locked, 1 = unlocked

    /**
     * @var string
     *
     * @ORM\Column(name="clean_title", type="string", length=255)
     */
    private $cleanTitle;

    /**
     * @var string
     *
     * @ORM\Column(name="first_poster_id", type="integer")
     */
    private $firstPosterId;

    /**
     * @var string
     *
     * @ORM\Column(name="first_poster_name", type="string", length=255)
     */
    private $firstPosterName;

    /**
     * @var string
     *
     * @ORM\Column(name="first_poster_colour", type="string", length=6, nullable=true)
     */
    private $firstPosterColour;

    /**
     * @var string
     *
     * @ORM\Column(name="last_poster_id", type="integer")
     */
    private $lastPosterId;

    /**
     * @var string
     *
     * @ORM\Column(name="last_poster_name", type="string", length=255)
     */
    private $lastPosterName;

    /**
     * @var string
     *
     * @ORM\Column(name="last_poster_colour", type="string", length=6, nullable=true)
     */
    private $lastPosterColour;

    /**
     * @var int
     *
     * @ORM\Column(name="last_post_id", type="integer", nullable=true)
     */
    private $lastPostId;

    /**
     * @var int
     *
     * @ORM\Column(name="last_post_date", type="datetime")
     */
    private $lastPostDate;

    /**
    * @var int
    */
    protected $posts_count;

    public function __construct()
    {
        $this->posts = new ArrayCollection();
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
     * Set title
     *
     * @param string $title
     *
     * @return Topic
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set type
     *
     * @param integer $type
     *
     * @return Topic
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return int
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set status
     *
     * @param integer $status
     *
     * @return Topic
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set cleanTitle
     *
     * @param string $cleanTitle
     *
     * @return Forum
     */
    public function setCleanTitle($cleanTitle)
    {
        $cleanTitle = Utility::cleanString($cleanTitle);

        $this->cleanTitle = $cleanTitle;

        return $this;
    }

    /**
     * Get cleanTitle
     *
     * @return string
     */
    public function getCleanTitle()
    {
        return $this->cleanTitle;
    }

    /**
     * Set firstPosterId
     *
     * @param integer $firstPosterId
     *
     * @return Topic
     */
    public function setFirstPosterId($firstPosterId)
    {
        $this->firstPosterId = $firstPosterId;

        return $this;
    }

    /**
     * Get firstPosterId
     *
     * @return integer
     */
    public function getFirstPosterId()
    {
        return $this->firstPosterId;
    }

    /**
     * Set firstPosterName
     *
     * @param string $firstPosterName
     *
     * @return Topic
     */
    public function setFirstPosterName($firstPosterName)
    {
        $this->firstPosterName = $firstPosterName;

        return $this;
    }

    /**
     * Get firstPosterName
     *
     * @return string
     */
    public function getFirstPosterName()
    {
        return $this->firstPosterName;
    }

    /**
     * Set firstPosterColour
     *
     * @param string $firstPosterColour
     *
     * @return Topic
     */
    public function setFirstPosterColour($firstPosterColour)
    {
        $this->firstPosterColour = $firstPosterColour;

        return $this;
    }

    /**
     * Get firstPosterColour
     *
     * @return string
     */
    public function getFirstPosterColour()
    {
        return $this->firstPosterColour;
    }

    /**
     * Set lastPosterId
     *
     * @param integer $lastPosterId
     *
     * @return Topic
     */
    public function setLastPosterId($lastPosterId)
    {
        $this->lastPosterId = $lastPosterId;

        return $this;
    }

    /**
     * Get lastPosterId
     *
     * @return integer
     */
    public function getLastPosterId()
    {
        return $this->lastPosterId;
    }

    /**
     * Set lastPosterName
     *
     * @param string $lastPosterName
     *
     * @return Topic
     */
    public function setLastPosterName($lastPosterName)
    {
        $this->lastPosterName = $lastPosterName;

        return $this;
    }

    /**
     * Get lastPosterName
     *
     * @return string
     */
    public function getLastPosterName()
    {
        return $this->lastPosterName;
    }

    /**
     * Set lastPosterColour
     *
     * @param string $lastPosterColour
     *
     * @return Topic
     */
    public function setLastPosterColour($lastPosterColour)
    {
        $this->lastPosterColour = $lastPosterColour;

        return $this;
    }

    /**
     * Get lastPosterColour
     *
     * @return string
     */
    public function getLastPosterColour()
    {
        return $this->lastPosterColour;
    }

    /**
     * Set lastPostId
     *
     * @param integer $lastPostId
     *
     * @return Topic
     */
    public function setLastPostId($lastPostId)
    {
        $this->lastPostId = $lastPostId;

        return $this;
    }

    /**
     * Get lastPostId
     *
     * @return integer
     */
    public function getLastPostId()
    {
        return $this->lastPostId;
    }

    /**
     * Set lastPostDate
     *
     * @param \DateTime $lastPostDate
     *
     * @return User
     */
    public function setLastPostDate(\DateTime $lastPostDate)
    {
        $this->lastPostDate = $lastPostDate;

        return $this;
    }

    /**
     * Get lastPostDate
     *
     * @return \DateTime
     */
    public function getLastPostDate()
    {
        return $this->lastPostDate;
    }

    /**
     * Set forum
     *
     * @param \ToG\ForumBundle\Entity\Forum $forum
     *
     * @return Post
     */
    public function setForum(\ToG\ForumBundle\Entity\Forum $forum = null)
    {
        $this->forum = $forum;

        return $this;
    }

    /**
     * Get forum
     *
     * @return \ToG\ForumBundle\Entity\Forum
     */
    public function getForum()
    {
        return $this->forum;
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
     * Get the value of Posts Count
     *
     * @return int
     */
    public function getPostsCount()
    {
        return $this->posts_count;
    }

    /**
     * Set the value of Posts Count
     *
     * @param int posts_count
     *
     * @return self
     */
    public function setPostsCount($posts_count)
    {
        $this->posts_count = $posts_count;

        return $this;
    }
}
