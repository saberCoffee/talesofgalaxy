<?php

namespace ToG\ForumBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use ToG\ForumBundle\Entity\Topic;

class LoadTopic implements FixtureInterface, ContainerAwareInterface, OrderedFixtureInterface
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
        $forumRepository = $this->container->get('doctrine')->getRepository('ToGForumBundle:Forum');
        $forums = $forumRepository->findAll();

        $userRepository =$this->container->get('doctrine')->getRepository('ToGUserBundle:User');
        $users = $userRepository->findAll();

        $topicTitles = array(
            'Le saviez-vous ?', 'Histire d\'un avatar', 'Hey-oh On rentre du Boulot', 'Quelques coquelicots qui caquètent', 'Les enchères débutent !', '[Tatooïne] Sur les traces du Jedi', '{Coruscant} Cantina Au Bon Lekku', 'El Rodia Casino! Le retour', '[Mythus VII] L\'antre du loup', '[Station de Kriko] Bras de fer sur Kriko', '[Syvris] Ce qui est à toi, est à moi !', '[Corellia] À projet inattendu ambassadeur inattendu', '[Kashyyyk] À la recherche du frère perdu', '[Espace] Un Nouvel Ordre', '[Etti IV] Le gardien dans les ténèbres...'
        );

        for ($i = 0 ; $i < 100 ; $i ++) {
            $newTopic = new Topic();

            $randomTitle = rand(0, count($topicTitles) - 1);
            $newTopic->setTitle($topicTitles[$randomTitle]);
            $newTopic->setCleanTitle($topicTitles[$randomTitle]);

            $newTopic->setType(rand(0,2));

            if ($i / 8 === 0) {
                $status = 2;
            } else {
                $status = rand(0,1);

                if ($status === 1) {
                    $status = rand(0,1);
                }
            }

            $newTopic->setStatus($status);

            $randomForum = rand(0, count($forums) - 1);
            $newTopic->setForum($forums[$randomForum]);

            // Ces informations seront mises à jour avec leurs valeurs définitives lors du LoadPost
            $newTopic->setFirstPosterId(1);
            $newTopic->setFirstPosterName('1');
            $newTopic->setLastPosterId(1);
            $newTopic->setLastPosterName('1');
            $newTopic->setLastPostId(1);

            $newDate = new \DateTime('now');
            $newTopic->setLastPostDate($newDate);

            $manager->persist($newTopic);

            $forum = $forumRepository->find($newTopic->getForum());
            $topics_count = $forum->getTopicsCount() + 1;
            $forum->setTopicsCount($topics_count);
            $manager->persist($forum);
        }

        $manager->flush();
    }

    public function getOrder()
    {
        return 3; // Load after forums
    }
}
