<?php

namespace ToG\ForumBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use ToG\ForumBundle\Entity\Post;
use ToG\ForumBundle\Entity\Topic;
use ToG\ForumBundle\Form\Type\PostType;
use ToG\RolePlayBundle\Entity\Character;
use ToG\UserBundle\Entity\User;

class CommonController extends Controller
{
    /**
     * Cette méthode raffraîchit le champ last_activity d'un utilisateur à chaque action qu'il entreprend
     * C'est notamment utilisé pour déterminer qui sont les utilisateurs en ligne
     *
     * @param   Object   $user   L'utilisateur connecté
     *
     * @return void
     */
    public function refreshActivity($user)
    {
        $em = $this->getDoctrine()->getManager();

        $newDate = new \DateTime('now');

        $user->setLastActivity($newDate);

        $em->persist($user);
        $em->flush();
    }

    /**
     * La page d'accueil du forum
     *
     * @return view
     */
    public function indexAction()
    {
        $user = $this->getUser();

        if ($user) {
            $characters = $user->getCharacters()->getValues();
            $this->refreshActivity($user);
        }

        $em = $this->getDoctrine();

        $usersRepository = $this->getDoctrine()->getRepository('ToGUserBundle:User');
        $usersOnline = $usersRepository->findUsersOnline();

        foreach ($usersOnline as $user)
        {
            dump($user);
        }

        $forumRepository = $em->getRepository('ToGForumBundle:Forum');
        $categories_and_forums = $forumRepository->hierarchizeForums();

        return $this->render('ToGForumBundle:Common:index.html.twig', array(
            // Utilisateurs du Qui est en ligne ?
            'usersOnline' => $usersOnline,

            // Liste des catégories et leurs forums
            'categories_and_forums' => $categories_and_forums,
        ));
    }

    /**
     * Page de lecture d'un forum
     *
     * @param  Request    $request     L'objet request
     * @param  integrer   $forumId     L'id du forum
     * @param  string     $cleanName   Le nom SEO du forum
     *
     * @return view
     */
    public function viewForumAction(Request $request, $forumId, $cleanName)
    {
        $user = $this->getUser();

        $em = $this->getDoctrine();

        $forumRepository = $em->getRepository('ToGForumBundle:Forum');
        $forum = $forumRepository->find($forumId);

        $topicRepository = $em->getRepository('ToGForumBundle:Topic');
        $topics = $topicRepository->findBy(
            ['forum' => $forum],
            ['type' => 'DESC', 'lastPostDate' => 'DESC']
        );

        foreach ($topics as $topic) {
            $posts = $topic->getPosts();
            $posts_count = 0;

            foreach($posts as $post) {
                $posts_count++;
            }

            $topic->setPostsCount($posts_count);
        }

        $post  = new Post();
        $topic = new Topic();
        $character = new Character();

        // Si on est dans le forum Créer votre personnage, on ajoute le formulaire dédié
        if ($forum->getName() === 'Créer votre personnage') {
            $form = $this->createForm(PostType::class, $post, array('new_character' => true));
            $characterCreation = true;
        } else {
            $form = $this->createForm(PostType::class, $post, array('new_topic' => true));
        }

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $date = new \DateTime('now');

            $post = $form->getData();

            if ($characterCreation) {
                $character = $post->getCharacter();

                if (!empty($character->getAvatar())) {
                    $avatar_directory = $this->container->getParameter('characters_avatars_directory');

                    $avatar = $character->getAvatar();
                    $avatarName  = $this->get('app.characters_avatar_uploader')->upload($avatar); // on upload temporairement le nouvel avatar
                    $avatarInfos = getimagesize($avatar_directory . '/' . $avatarName); // on récupère ses informations

                    // si ses dimensions ne sont pas correctes, alors on considère l'upload échoué et on supprime l'avatar
                    if ($avatarInfos[0] !== $avatarInfos[1] || $avatarInfos[0] !== 150) {
                        $failedUpload = true;

                        unlink($avatar_directory . '/' . $avatarName);

                        $character->setAvatar('');
                    }
                }

                $character
                    ->setUser($user)
                ;

                if (!empty($_POST['temp_avatar'])) { // si on crop un avatar
                    $avatarName = $_POST['temp_avatar'];
                    $character->setAvatar($avatarName);
                }

                if (!empty($character->getAvatar())) {
                    $character->setAvatar($avatarName);
                }

                $em->persist($character);
                $em->flush();
            }

            // Maintenant, on peut récupérer la partie du form qui nous intéresse : le Topic
            $topic = $post->getTopic();
            $topic
                ->setForum($forum)
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
                ->setUser($user)
                ->setPostDate($date)
            ;

            // On associe le Post au Topic
            $post->setTopic($topic);

            // Puis on met à jour le Topic en utilisant l'id du Post
            $em->persist($post);
            $em->flush();

            $topic->setLastPostId($post->getId());

            $em->flush();

            $forum
                ->incrementTopicsCount()
                ->incrementPostsCount()
            ;

            $em->flush();

            return $this->redirectToRoute('viewtopic', array(
                'topicId'    => $topic->getId(),
                'cleanTitle' => $topic->getCleanTitle(),
                '_fragment'  => 'post-' . $post->getId()
            ));
        }

        return $this->render('ToGForumBundle:Common:viewforum.html.twig', array(
            // Titre de la page
            'pageTitle' => $forum->getName(),

            // Données du forum visionné
            'forumData'     => $forum,
            'newTopicLabel' => ($forum->getName() === 'Créer votre personnage') ? 'Créer un personnage' : 'Ouvrir un sujet',

            // Liste des sujets du forum visionné
            'topics' => $topics,

            // Formulaire de nouveau sujet
            'form' => $form->createView(),

            // Misc
            'characterCreation' => (isset($characterCreation)) ? true : false
        ));
    }

    /**
     * Page de lecture d'un sujet
     *
     * @param  Request    $request      L'objet request
     * @param  integrer   $topicId      L'id du sujet consulté
     * @param  string     $cleanTitle   Le titre SEO du sujet
     *
     * @return view
     */
    public function viewTopicAction(Request $request, $topicId, $cleanTitle)
    {
        $user = $this->getUser();

        $topic = $this->getDoctrine()
            ->getRepository('ToGForumBundle:Topic')
            ->find($topicId);

        $forumRepository = $this->getDoctrine()->getRepository('ToGForumBundle:Forum');
        $forum = $forumRepository->find($topic->getForum());

        $posts = $topic->getPosts();

        $userRepository = $this->getDoctrine()->getRepository('ToGUserBundle:User');

        //-- Start : Formulaire de réponse
        //
        $post = new Post();

        $form = $this->createForm(PostType::class, $post);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $date = new \DateTime('now');

            $post = $form->getData();

            $post
                ->setUser($user)
                ->setPostDate($date)
            ;

            // On associe le Post au Topic
            $post->setTopic($topic);

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

            $forum->incrementPostsCount();

            $em->flush();

            return $this->redirectToRoute('viewtopic', array(
                'topicId'    => $topic->getId(),
                'cleanTitle' => $topic->getCleanTitle(),
                '_fragment'  => 'post-' . $post->getId()
            ));
        }
        //
        //-- End : Formulaire de réponse

        return $this->render('ToGForumBundle:Common:viewtopic.html.twig', array(
            // Titre de la page
            'pageTitle' => $topic->getTitle(),

            // Données du sujet visionné
            'topicData' => $topic,

            // Données du forum courant
            'forumData' => $forum,

            // Liste des messages du forum visionné
            'posts' => $posts,

            // Formulaire de réponse
            'form' => $form->createView(),
        ));
    }

    /**
     * Page d'édition d'un message
     *
     * @todo   A l'avenir, il serait intéressant de rester dans la méthode viewTopic et d'éditer les messages en ajax
     *
     * @param  Request    $request     L'objet request
     * @param  integrer   $postId      L'id du message à éditer
     *
     * @return view
     */
    public function editPostAction(Request $request, $postId)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_REMEMBERED');
        $user = $this->getUser();

        $postRepository = $this->getDoctrine()->getRepository('ToGForumBundle:Post');
        $post = $postRepository->find($postId);

        $topic = $post->getTopic();

        $forumRepository = $this->getDoctrine()->getRepository('ToGForumBundle:Forum');
        $forum = $forumRepository->find($topic->getForum());

        $form = $this->createForm(PostType::class, $post);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $date = new \DateTime('now');

            $post = $form->getData();

            $post
                ->setUser($user)
                ->setPostDate($date)
            ;

            // On associe le Post au Topic
            $em->persist($post);
            $em->flush();

            return $this->redirectToRoute('viewtopic', array(
                'topicId'    => $topic->getId(),
                'cleanTitle' => $topic->getCleanTitle(),
                '_fragment'  => 'post-' . $postId
            ));
        }

        return $this->render('ToGForumBundle:Common:posting.html.twig', array(
            // Titre de la page
            'pageTitle' => 'Modifier un message',

            // Mode de posting
            'mode' => 'editPost',

            // Formulaire
            'form' => $form->createView(),

            // Données du forum où on poste
            'forumData' => $forum,

            // Données du sujet où on poste
            'topicData' => $topic
        ));
    }
}
