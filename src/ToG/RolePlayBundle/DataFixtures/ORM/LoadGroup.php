<?php

namespace ToG\RolePlayBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use ToG\RolePlayBundle\Entity\Group;

class LoadGroup implements FixtureInterface, ContainerAwareInterface, OrderedFixtureInterface
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
        $groups = array(
            0 => [
                'name'   => 'Maîtres du Jeu',
                'colour' => 'B25D3B',
                'is_not_rp' => 1,
                'abreviation' => 'gm'
            ],
            2 => [
                'name'   => 'République Galactique',
                'colour' => 'ec6216',
                'is_not_rp' => 0,
                'abreviation' => 'rg'
            ],
            3 => [
                'name'   => 'Conglomérat Impérial',
                'colour' => '624079',
                'is_not_rp' => 0,
                'abreviation' => 'ci'
            ],
            4 => [
                'name'   => 'Confédération des Mondes Souverains',
                'colour' => '922f3e',
                'is_not_rp' => 0,
                'abreviation' => 'conf'
            ],
            5 => [
                'name'   => 'Ordre Jedi',
                'colour' => '1675B7',
                'is_not_rp' => 0,
                'abreviation' => 'jedi'
            ],
            6 => [
                'name'   => 'Ordre Sith',
                'colour' => 'e90707',
                'is_not_rp' => 0,
                'abreviation' => 'sith'
            ],
            7 => [
                'name'   => 'Les Résilients',
                'colour' => '7C7C7C',
                'is_not_rp' => 0,
                'abreviation' => 'res'
            ],
            8 => [
                'name'   => 'Indépendants',
                'colour' => '5B8D4D',
                'is_not_rp' => 0,
                'abreviation' => 'inde'
            ]
        );

        foreach ($groups as $key => $group) {
            $newGroup = new Group();

            $newGroup
                ->setId($key)
                ->setName($group['name'])
                ->setAbreviation($group['abreviation'])
                ->setColour($group['colour'])
                ->setIsNotRp($group['is_not_rp'])
                ->setRoles(array('ROLE_USER'))
            ;

            if ($group['name'] === 'Maîtres du Jeu') {
                $newGroup->setRoles(array('ROLE_USER', 'ROLE_GM'));
            }

            $manager->persist($newGroup);

            $manager->flush();
        }
    }

    public function getOrder()
    {
        return 4; // load after Post
    }
}
