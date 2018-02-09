<?php

namespace ToG\UserBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * UserRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class UserRepository extends \Doctrine\ORM\EntityRepository
{
    public function findUsersOnline()
    {
        $last_five_minutes = new \DateTime();
        $last_five_minutes->modify('-5 minutes');

        return $this->getEntityManager()
            ->createQuery(
                'SELECT u.id, u.username FROM ToGUserBundle:User u WHERE u.lastActivity >= :last_five_minutes ORDER BY u.username ASC'
            )
            ->setParameter('last_five_minutes', $last_five_minutes)
            ->getResult()
        ;
    }

    public function findUsersOfTheDay()
    {
        $last_day = new \DateTime();
        $last_day->modify('-24 hours');

        return $this->getEntityManager()
            ->createQuery(
                'SELECT u.id, u.username FROM ToGUserBundle:User u WHERE u.lastLogin >= :last_day ORDER BY u.username ASC'
            )
            ->setParameter('last_day', $last_day)
            ->getResult()
        ;
    }
}