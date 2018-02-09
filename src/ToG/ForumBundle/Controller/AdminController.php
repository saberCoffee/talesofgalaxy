<?php

namespace ToG\ForumBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use ToG\ForumBundle\Form\Type\ForumType;
use ToG\ForumBundle\Entity\Forum;

class AdminController extends Controller
{
    /**
     * La page d'accueil du panneau d'administration
     *
     * @return view
     */
    public function dashboardAction()
    {
        return $this->render('ToGForumBundle:Admin:dashboard.html.twig', array(
        ));
    }

    /**
     * La page d'administration des forums
     *
     * @param  Request    $request     L'objet request
     *
     * @return view
     */
    public function forumsListAction(Request $request)
    {
        $forumRepository = $this->getDoctrine()->getRepository('ToGForumBundle:Forum');
        $categories_and_forums = $forumRepository->hierarchizeForums();

        $forumsList = $forumRepository->findAll();

        $forumsChoices = [];
        foreach ($forumsList as $forum) {
            $forumsChoices[$forum->getName()] = $forum->getId();
        }

        $forum = new Forum();

        $form = $this->createForm(ForumType::class, $forum, array('categories' => $forumsChoices));

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $forum
                ->setName($forum->getName())
                ->setDescription($forum->getDescription())
                ->setParentId($forum->getParentId())
                ->setType($forum->getType())
                ->setCleanName($forum->getName())
            ;

            $em->persist($forum);
            $em->flush();

            return $this->redirectToRoute('forums_list');
        }

        return $this->render('ToGForumBundle:Admin:forums_list.html.twig', array(
            // Liste des catégories et leurs forums
            'categories_and_forums' => $categories_and_forums,

            // Formulaire d'ajout de forum
            'form' => $form->createView(),
        ));
    }

    /**
     * Page d'édition d'un forum
     *
     * @param  Request    $request     L'objet request
     * @param  integrer   $forumId     L'id du forum
     * @param  string     $cleanName   Le nom SEO du forum
     *
     * @return view
     */
    public function forumManagementAction(Request $request, $forumId, $cleanName)
    {
        $user = $this->getUser();

        $forumRepository = $this->getDoctrine()->getRepository('ToGForumBundle:Forum');
        $forum  = $forumRepository->find($forumId);

        $forumsList = $forumRepository->findAll();

        $forumsChoices = [];
        foreach ($forumsList as $forum) {
            $forumsChoices[$forum->getName()] = $forum->getId();
        }

        $form = $this->createForm(ForumType::class, $forum, array('categories' => $forumsChoices));

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $forum
                ->setName($forum->getName())
                ->setDescription($forum->getDescription())
                ->setParentId($forum->getParentId())
                ->setType($forum->getType())
                ->setCleanName($forum->getName())
            ;

            $em->persist($forum);
            $em->flush();

            return $this->redirectToRoute('forums_list');
        }

        return $this->render('ToGForumBundle:Admin:forum_management.html.twig', array(
            // Titre de la page
            'pageTitle' => 'Administration - ' . $forum->getName(),

            // Données du forum visionné
            'forumData' => $forum,

            // Formulaire d'édition de forum
            'form' => $form->createView(),
        ));
    }
}
