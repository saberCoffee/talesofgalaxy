<?php

namespace ToG\ForumBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use ToG\ForumBundle\Utility\Utility;

/**
 * Forum
 *
 * @ORM\Table(name="tog_forum")
 * @ORM\Entity(repositoryClass="ToG\ForumBundle\Repository\ForumRepository")
 */
class Forum
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
     * @ORM\Column(name="description", type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @var int
     *
     * @ORM\Column(name="parent_id", type="integer", nullable=true)
     */
    private $parentId;

    /**
     * @var int
     *
     * @ORM\Column(name="type", type="integer")
     */
    private $type; // type 0 = categorie, 1 = forum, 2 = forum_link ?

    /**
     * @var string
     *
     * @ORM\Column(name="clean_name", type="string", length=255)
     */
    private $cleanName;

    /**
     * @var array
     */
    private $subForums;

    /**
     * @ORM\OneToMany(targetEntity="Topic", mappedBy="forum")
     */
    private $topics;

    /**
    * @var int
    *
    * @ORM\Column(name="topics_count", type="integer", nullable=true)
    */
    private $topics_count;

    /**
    * @var int
    *
    * @ORM\Column(name="posts_count", type="integer", nullable=true)
    */
    private $posts_count;

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
     * Set name
     *
     * @param string $name
     *
     * @return Forum
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
     * Set description
     *
     * @param string $description
     *
     * @return Forum
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set parentId
     *
     * @param integer $parentId
     *
     * @return Forum
     */
    public function setParentId($parentId)
    {
        $this->parentId = $parentId;

        return $this;
    }

    /**
     * Get parentId
     *
     * @return int
     */
    public function getParentId()
    {
        return $this->parentId;
    }

    /**
     * Set type
     *
     * @param integer $type
     *
     * @return Forum
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
     * Set cleanName
     *
     * @param string $cleanName
     *
     * @return Forum
     */
    public function setCleanName($cleanName)
    {
        $cleanName = Utility::cleanString($cleanName);

        $this->cleanName = $cleanName;

        return $this;
    }

    /**
     * Get cleanName
     *
     * @return string
     */
    public function getCleanName()
    {
        return $this->cleanName;
    }

    /**
     * Set subForums
     *
     * @param array subForums
     *
     * @return Forum
     */
    public function setSubForums($subForums)
    {
        $this->subForums = $subForums;

        return $this;
    }

    /**
     * Get subForums
     *
     * @return Forum
     */
    public function getSubForums()
    {
        return $this->subForums;
    }

    /**
     * Add topic
     *
     * @param \ToG\ForumBundle\Entity\Topic $topic
     *
     * @return Topic
     */
    public function addTopic(\ToG\ForumBundle\Entity\Topic $topic)
    {
        $this->topics[] = $topic;

        return $this;
    }

    /**
     * Remove topic
     *
     * @param \ToG\ForumBundle\Entity\Topic $topic
     */
    public function removeTopic(\ToG\ForumBundle\Entity\Topic $topic)
    {
        $this->topics->removeElement($topic);
    }

    /**
     * Get topics
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTopics()
    {
        return $this->topics;
    }

    /**
     * Get the value of Topics Count
     *
     * @return int
     */
    public function getTopicsCount()
    {
        return $this->topics_count;
    }

    /**
     * Set the value of Topics Count
     *
     * @param int topics_count
     *
     * @return self
     */
    public function setTopicsCount($topics_count)
    {
        $this->topics_count = $topics_count;

        return $this;
    }

    /**
     * Add +1 to Topics Count
     *
     * @return self
     */
    public function incrementTopicsCount()
    {
        $this->topics_count++;

        return $this;
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

    /**
     * Add +1 to Posts Count
     *
     * @return self
     */
    public function incrementPostsCount()
    {
        $this->posts_count++;

        return $this;
    }
}
