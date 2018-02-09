<?php

namespace ToG\ForumBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use ToG\ForumBundle\Entity\Forum;

class LoadForum implements FixtureInterface, ContainerAwareInterface, OrderedFixtureInterface
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
        $categories_and_forums = array(
            0 => [
                'name'   => 'Accueil & Règles du jeu',
                'forums' => [
                    0 => [
                        'name' => 'Règles du jeu',
                        'desc' => 'Indispensables à lire avant de jouer, il s\'agit de la la première étape de votre aventure sur Tales !'
                    ],
                    1 => [
                        'name' => 'Annonces du staff',
                        'desc' => 'Il arrive que l\'équipe du forum dise autre chose que des bêtises, et c\'est ici que vous pourrez vous tenir au courant.'
                    ],
                    2 => [
                        'name' => 'Vos suggestions',
                        'desc' => 'Parce que vous avez peut-être des idées pour améliorer le forum ou bien le jeu, il vous faut un endroit où nous les montrer.'
                    ],
                    3 => [
                        'name' => 'Vos absences',
                        'desc' => 'Si vous devez vous absenter quelques jours ou plus, pensez à l\'annoncer au reste des membres.'
                    ]
                ]
            ],
            1 => [
                'name'   => 'Encyclopédie Galactique',
                'forums' => [
                    0 => [
                        'name' => 'Créer votre personnage',
                        'desc' => 'Il est temps d\'embarquer pour la plus grande aventure de votre vie !'
                    ],
                    1 => [
                        'name' => 'Personnages Joueurs',
                        'desc' => 'Ici sont archivées les fiches des Personnages Joueurs.'
                    ],
                    2 => [
                        'name' => 'Personnages non Joueurs',
                        'desc' => 'Ici sont archivées les fiches des Personnages non Joueurs.'
                    ]
                ]
            ],
            2 => [
                'name'   => 'Le jeu de rôle',
                'forums' => [

                ]
            ],
            3 => [
                'name'   => 'Hors jeu',
                'forums' => [

                ]
            ]
        );

        foreach ($categories_and_forums as $categorie) {
            $newCategorie = new Forum();

            $newCategorie->setName($categorie['name']);

            $newCategorie->setDescription('');

            // Les catégories ont forcément 0 pour parent
            $newCategorie->setParentId(0);

            // Les catégories sont de type 0
            $newCategorie->setType(0);

            $newCategorie->setTopicsCount(0);
            $newCategorie->setPostsCount(0);

            $newCategorie->setCleanName($categorie['name']);

            $manager->persist($newCategorie);

            $manager->flush();

            foreach($categorie['forums'] as $forum) {
                $newForum = new Forum();

                $newForum->setName($forum['name']);

                $newForum->setDescription($forum['desc']);

                // Ce forum reprend la dernière catégorie en tant que parent
                $parentId = $newCategorie->getId();
                $newForum->setParentId($parentId);

                // Les forums sont de type 1 ou 2 pour les forums-liens
                $newForum->setType(1);

                $newForum->setTopicsCount(0);
                $newForum->setPostsCount(0);

                $newForum->setCleanName($forum['name']);

                $manager->persist($newForum);

                $manager->flush();
            }
        }
    }

    public function getOrder()
    {
        return 2;
    }
}
