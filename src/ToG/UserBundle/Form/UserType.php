<?php

namespace ToG\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Tog\UserBundle\Entity\User;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class, array(
                'label' => false,
                'attr'  => array('placeholder' => 'Adresse email')
            ))
            ->add('username', TextType::class, array(
                'label' => false,
                'attr'  => array('placeholder' => 'Nom d\'utilisateur')
            ))
        ;

        // En mode édition de profil, on rajoute des champs au formulaire
        if ($options['action'] === 'edit') {
            $builder
                ->add('avatar', FileType::class, array(
                    'label'      => 'Sélectionner votre avatar',
                    'required'   => false,
                    'data_class' => null,
                ))
                ->add('password', PasswordType::class, array(
                    'label'      => false,
                    'attr'       => array('placeholder' => 'Mot de passe actuel'),
                    'required'   => false,
                    'mapped'     => false,
                ))
                ->add('newPlainPassword', RepeatedType::class, array(
                    'type' => PasswordType::class,
                    'invalid_message' => 'Ces champs doivent être identiques.',
                    'required'   => false,
                    'first_options'  => array(
                        'label' => false,
                        'attr'  => array('placeholder' => 'Nouveau mot de passe'),
                    ),
                    'second_options' => array(
                        'label' => false,
                        'attr'  => array('placeholder' => 'Confirmer le mot de passe'),
                    ),
                ))
                ->add('save', SubmitType::class, array(
                     'label' => 'Enregistrer',
                     'attr'  => array('class' => 'btn btn-default')
                 ))
            ;
        } else {
            $builder
                ->add('plainPassword', RepeatedType::class, array(
                    'type' => PasswordType::class,
                    'invalid_message' => 'Ces champs doivent être identiques.',
                    'first_options'  => array(
                        'label' => false,
                        'attr'  => array('placeholder' => 'Mot de passe'),
                    ),
                    'second_options' => array(
                        'label' => false,
                        'attr'  => array('placeholder' => 'Confirmer le mot de passe'),
                    ),
                ))
            ;
        }
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => User::class,
        ));
    }
}
