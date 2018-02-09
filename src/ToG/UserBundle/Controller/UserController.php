<?php

namespace ToG\UserBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use ToG\UserBundle\Form\UserType;
use ToG\UserBundle\Entity\User;

class UserController extends Controller
{
    /**
     * Page de consultation de profil
     *
     * @param  Request    $request      L'objet request
     * @param  integrer   $userId      L'id du profil consulté
     *
     * @return view
     */
    public function viewProfileAction(Request $request, $userId)
    {
        $user = $this->getUser();

        $userRepository = $this->getDoctrine()->getRepository('ToGUserBundle:User');
        $viewed_user    = $userRepository->find($userId);

        // DevTemp : Array des factions
        $factions = ['faction-rg', 'faction-ci', 'faction-conf', 'faction-jedi', 'faction-sith', 'faction-res', 'faction-inde'];
        $faction  = $factions[rand(0, count($factions) - 1)];

        return $this->render('ToGUserBundle:User:viewprofile.html.twig', array(
            // Titre de la page
            'pageTitle' => 'Profil de ' . $viewed_user->getUsername(),

            // Données de l'user consulté
            'userData' => $viewed_user,

            // DevTemp
            'faction' => $faction
        ));
    }


    /**
     * Page d'édition de profil
     *
     * @param  Request    $request      L'objet request
     * @param  integrer   $userId      L'id du profil consulté
     *
     * @return view
     */
    public function editProfileAction(Request $request, $userId)
    {
        $user = $this->getUser();

        $isOwner = false;
        if ($user->getId() == $userId) {
            $isOwner = true; // true si on édite son profil, false si c'est un admin qui édite celui de quelqu'un d'autre
        }

        $userRepository = $this->getDoctrine()->getRepository('ToGUserBundle:User');
        $viewed_user    = $userRepository->find($userId);

        $old_avatar = $viewed_user->getAvatar();

        $form = $this->createForm(UserType::class, $viewed_user, array('action' => 'edit'));

        $form->handleRequest($request);

        // A la soumission du formulaire, on vérifie que l'avatar est conforme...
        if ($form->isSubmitted()) {
            if (!empty($viewed_user->getAvatar())) {
                $avatar_directory = $this->container->getParameter('users_avatars_directory');

                $avatar = $viewed_user->getAvatar();
                
                $avatarName  = $this->get('app.users_avatar_uploader')->upload($avatar); // on upload temporairement le nouvel avatar
                $avatarInfos = getimagesize($avatar_directory . '/' . $avatarName); // on récupère ses informations

                // si ses dimensions ne sont pas correctes, alors on considère l'upload échoué et on supprime l'avatar
                if ($avatarInfos[0] !== $avatarInfos[1] || $avatarInfos[0] !== 150) {
                    $failedUpload = true;

                    unlink($avatar_directory . '/' . $avatarName);

                    $viewed_user->setAvatar($old_avatar); // on re-set l'ancien avatar éviter d'afficher une image inexistante
                } else {
                    // Sinon, on supprime l'ancien avatar s'il y en a
                    if ($old_avatar) {
                        unlink($avatar_directory . '/' . $old_avatar);
                    }
                }
            }
        }

        if ($form->isSubmitted() && $form->isValid() && !isset($failedUpload)) {
            // Si l'utilisateur change son mot de passe, on le ré-encore avant de l'enregistrer
            if ($viewed_user->getNewPlainPassword()) {
                $password = $this->get('security.password_encoder')
                    ->encodePassword($viewed_user, $viewed_user->getNewPlainPassword());
                $viewed_user->setPassword($password);
            }

            if (!empty($viewed_user->getAvatar())) {
                $viewed_user->setAvatar($avatarName);
            }

            $em = $this->getDoctrine()->getManager();
            $em->persist($viewed_user);
            $em->flush();

            return $this->redirectToRoute('editprofile', array(
                'userId' => $userId
            ));
        }

        return $this->render('ToGUserBundle:User:editprofile.html.twig', array(
            // Titre de la page
            'pageTitle' => 'Panneau de contrôle utilisateur',

            // Données de l'user consulté
            'userData' => $viewed_user,

            // Formulaire d'édition de profil
            'form' => $form->createView(),
        ));
    }
}
