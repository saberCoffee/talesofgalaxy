<?php

namespace ToG\ForumBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use ToG\ForumBundle\Entity\Post;
use ToG\ForumBundle\Entity\Topic;
use ToG\ForumBundle\Form\Type\PostType;
use ToG\UserBundle\Entity\User;

class CommonController extends Controller
{
    public function refreshActivity($user)
    {
        $em = $this->getDoctrine()->getManager();

        $newDate = new \DateTime('now');

        $user->setLastActivity($newDate);

        $em->persist($user);
        $em->flush();
    }

    public function indexAction()
    {
        $user = $this->getUser();

        if ($user) {
            $this->refreshActivity($user);
        }

        $em = $this->getDoctrine()->getManager();
        $usersOnline = $em->getRepository('ToGUserBundle:User')
            ->findUsersOnline();

        $forumRepository = $this->getDoctrine()->getRepository('ToGForumBundle:Forum');
        $categories_and_forums = $forumRepository->findAll();

        // Afin de pouvoir les afficher correctement dans la Vue, on va ranger les sous-forums dans leurs parents
        // Pour commencer, on sépare les catégories dans un array qui leur est propre
        $categories = [];
        foreach ($categories_and_forums as $categorie) {
            // Si le type de l'objet en cours d'itération est 0, alors c'est une catégorie
            if ($categorie->getType() === 0) {
                $categorieId = $categorie->getId();

                // On l'ajoute à notre array précédemment créé
                $categories[$categorieId] = $categorie;

                // Puis on initialise un nouvel array qui contiendra tous les sous-forums de cette catégorie
                $subForums = [];

                foreach ($categories_and_forums as $forum) {
                    // Si le type de l'objet en cours d'itération est 1, alors c'est un forum
                    // On vérifie aussi si l'id de son parent est égale à l'id de la catégorie en cours d'itération
                    if ($forum->getType() === 1 && $forum->getParentId() == $categorieId) {
                        // On ajoute ce forum à notre array de sous-forums
                        $subForums[] = $forum;
                    }
                }

                // Enfin, on va pouvoir setter les sous-forums de la catégorie en lui donnant la liste des sous-forums qui lui appartiennent
                $categories[$categorieId]->setSubForums($subForums);
            }
        }

        return $this->render('ToGForumBundle:Common:index.html.twig', array(
            // Utilisateurs du Qui est en ligne ?
            'usersOnline' => $usersOnline,

            // Liste des catégories et leurs forums
            'categories' => $categories,
        ));
    }

    public function viewForumAction($forumId, $cleanName)
    {
        $forumRepository = $this->getDoctrine()->getRepository('ToGForumBundle:Forum');
        $forum = $forumRepository->find($forumId);

        $topicRepository = $this->getDoctrine()->getRepository('ToGForumBundle:Topic');
        $topics = $topicRepository
            ->findBy(
                array('forumId' => $forumId),
                array('type' => 'DESC', 'lastPostDate' => 'DESC')
            );

        return $this->render('ToGForumBundle:Common:viewforum.html.twig', array(
            // Titre de la page
            'pageTitle' => $forum->getName(),

            // Données du forum visionné
            'forumData' => $forum,

            // Liste des sujets du forum visionné
            'topics' => $topics,
        ));
    }

    public function viewTopicAction($topicId, $cleanTitle)
    {
        $topicRepository = $this->getDoctrine()->getRepository('ToGForumBundle:Topic');
        $topic = $topicRepository->find($topicId);

        $postRepository = $this->getDoctrine()->getRepository('ToGForumBundle:Post');
        $posts = $postRepository->findByTopicId($topicId);

        // DevTemp : Array des factions
        $factions = ['faction-rg', 'faction-ci', 'faction-conf', 'faction-jedi', 'faction-sith', 'faction-res', 'faction-inde'];
        foreach ($posts as $post) {
            $post->faction = $factions[rand(0, count($factions) - 1)];
        }

        return $this->render('ToGForumBundle:Common:viewtopic.html.twig', array(
            // Titre de la page
            'pageTitle' => $topic->getTitle(),

            // Données du sujet visionné
            'topicData' => $topic,

            // Liste des messages du forum visionné
            'posts' => $posts,
        ));
    }

    public function newTopicAction(Request $request, $forumId)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_REMEMBERED');
        $user = $this->getUser();

        $forumRepository = $this->getDoctrine()->getRepository('ToGForumBundle:Forum');
        $forum = $forumRepository->find($forumId);

        $post  = new Post();
        $topic = new Topic();

        $form = $this->createForm(PostType::class, $post, array('new_topic' => true));

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $date = new \DateTime('now');

            // $form->getData() renvoie toutes les données du forumaire
            // Le Topic étant une propriété du Post, on commence par initier une variable pour celui-ci
            $post = $form->getData();

            // Maintenant, on peut récupérer la partie du form qui nous intéresse : le Topic
            $topic = $post->getTopic();
            $topic
                ->setForumId($forumId)
                ->setFirstPosterId($user->getId())
                ->setFirstPosterName($user->getUsername())
                ->setLastPosterId($user->getId())
                ->setLastPosterName($user->getUsername())
                ->setType(0) // pour l'instant, un topic est forcément normal
                ->setStatus(1) // pour l'instant, un topic est forcément unlocked
                ->setCleanTitle($topic->getTitle())
                ->setLastPostDate($date)
            ;

            // On enregistre le Topic...
            $em->persist($topic);
            $em->flush();

            // Puis on enregistre le Post en utilisant l'id du Popic
            $post
                ->setTopicId($topic->getId())
                ->setPosterId($user->getId())
                ->setPosterName($user->getUsername())
                ->setPostDate($date)
            ;

            // Puis on met à jour le Topic en utilisant l'id du Post
            $em->persist($post);
            $em->flush();

            $topic->setLastPostId($post->getId());

            $em->flush();

            dump($post);
            dump($topic);

            return $this->redirectToRoute('viewtopic', array(
                'topicId'    => $topic->getId(),
                'cleanTitle' => $topic->getCleanTitle(),
                '_fragment'  => 'post-' . $post->getId()
            ));
        }

        return $this->render('ToGForumBundle:Common:posting.html.twig', array(
            // Titre de la page
            'pageTitle' => 'Ouvrir un nouveau sujet',

            // Mode de posting
            'mode' => 'newTopic',

            // Formulaire
            'form' => $form->createView(),

            // Données du forum où on ouvre le sujet
            'forumData' => $forum,
        ));
    }

    public function newPostAction(Request $request, $topicId)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_REMEMBERED');
        $user = $this->getUser();

        $topicRepository = $this->getDoctrine()->getRepository('ToGForumBundle:Topic');
        $topic = $topicRepository->find($topicId);

        $post = new Post();

        $form = $this->createForm(PostType::class, $post);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $date = new \DateTime('now');

            $post = $form->getData();

            $post
                ->setTopicId($topicId)
                ->setPosterId($user->getId())
                ->setPosterName($user->getUsername())
                ->setPostDate($date)
            ;
            $em->persist($post);
            $em->flush();

            $topic
                ->setLastPosterId($user->getId())
                ->setLastPosterName($user->getUsername())
                ->setLastPostId($post->getId())
                ->setLastPostDate($date)
            ;

            $em->persist($topic);
            $em->flush();

            dump($post);
            dump($topic);

            return $this->redirectToRoute('viewtopic', array(
                'topicId'    => $topic->getId(),
                'cleanTitle' => $topic->getCleanTitle(),
                '_fragment'  => 'post-' . $post->getId()
            ));
        }

        return $this->render('ToGForumBundle:Common:posting.html.twig', array(
            // Titre de la page
            'pageTitle' => 'Poster une réponse',

            // Mode de posting
            'mode' => 'newPost',

            // Formulaire
            'form' => $form->createView(),

            // Données du sujet où on poste
            'topicData' => $topic,
        ));
    }
}
