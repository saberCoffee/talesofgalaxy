<?php

namespace ToG\UserBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use ToG\UserBundle\Entity\User;

class LoadUser implements FixtureInterface, ContainerAwareInterface, OrderedFixtureInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function load(ObjectManager $manager)
    {
        // Les noms d'utilisateurs à créer
        $listNames = ['L\'Observateur', 'Asuka', 'Zarga', 'Pravuil', 'Raltir', 'SpicyShark', 'Xander'];

        foreach ($listNames as $name) {
            // On crée l'utilisateur
            $user = new User();

            // Le nom d'utilisateur et le mot de passe sont identiques pour l'instant
            $user->setUsername($name);

            $user->setEmail($name . '@talesofgalaxy.fr');

            $password = $this->container->get('security.password_encoder')
                ->encodePassword($user, '123456');
            $user->setPassword($password);

            // On définit uniquement le role ROLE_USER qui est le role de base
            $user->setRoles(['ROLE_USER']);

            if ($name === 'L\'Observateur') {
                $user->setRoles(['ROLE_USER', 'ROLE_GM', 'ROLE_ADMIN', 'ROLE_SUPER_ADMIN']);
            }

            $newDate = new \DateTime('now');
            $user->setRegisterDate($newDate);
            $user->setLastLogin($newDate);
            $user->setLastActivity($newDate);

            // On le persiste
            $manager->persist($user);
        }

        // On déclenche l'enregistrement
        $manager->flush();
    }

    public function getOrder()
    {
        return 1;
    }
}
