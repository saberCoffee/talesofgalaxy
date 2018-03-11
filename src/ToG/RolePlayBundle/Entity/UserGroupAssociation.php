<?php

namespace ToG\RolePlayBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

 /**
  * UserGroupAssociation
  *
  * @ORM\Table(name="tog_user_group_associations")
  * @ORM\Entity(repositoryClass="ToG\ForumBundle\Repository\TopicRepository")
  */
class UserGroupAssociation
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
     * @ORM\ManyToOne(targetEntity="\ToG\UserBundle\Entity\User", inversedBy="user_group_associations", fetch="EAGER")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    protected $user;

    /**
     * @ORM\ManyToOne(targetEntity="Group", inversedBy="user_group_associations", fetch="EAGER")
     * @ORM\JoinColumn(name="group_id", referencedColumnName="id")
     */
    private $group;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set user
     *
     * @param \ToG\UserBundle\Entity\User $user
     * @return UserGroupAssociation
     */
    public function setUser(\ToG\UserBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \ToG\UserBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set group
     *
     * @param \ToG\RolePlayBundle\Entity\Group $group
     * @return UserGroupAssociation
     */
    public function setGroup(\ToG\RolePlayBundle\Entity\Group $group = null)
    {
        $this->group = $group;

        return $this;
    }

    /**
     * Get group
     *
     * @return \ToG\RolePlayBundle\Entity\Group
     */
    public function getGroup()
    {
        return $this->group;
    }
}
