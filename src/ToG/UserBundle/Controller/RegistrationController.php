<?php

namespace ToG\UserBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use ToG\UserBundle\Form\UserType;
use ToG\UserBundle\Entity\User;

class RegistrationController extends Controller
{
    public function registerAction(Request $request)
    {
        $user = new User;

        $form = $this->createForm(
            UserType::class, $user, array(
                'attr' => array('class'=>'form-registration')
            )
        );

        $form->handleRequest($request);
        if (false === $user->getPlainPassword() || (empty($user->getPlainPassword()) && '0' != $user->getPlainPassword())) {
            $blankPassword = true;
        }

        if ($form->isSubmitted() && $form->isValid() && !isset($blankPassword)) {

            $password = $this->get('security.password_encoder')
                ->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);

            $user->setRoles(array('ROLE_USER'));

            $newDate = new \DateTime('now');
            $user->setRegisterDate($newDate);
            $user->setLastLogin($newDate);
            $user->setLastActivity($newDate);

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            $token = new UsernamePasswordToken($user, null, 'main', $user->getRoles());
            $this->get('security.token_storage')->setToken($token);
            $this->get('session')->set('_security_main', serialize($token));

            return $this->redirectToRoute('index');
        }

        return $this->render('ToGUserBundle:Registration:register.html.twig', array(
            // Formulaire de réponse
            'form' => $form->createView(),
        ));
    }
}
