<?php

namespace ToG\ForumBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use ToG\ForumBundle\Entity\Post;

class PostType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        if ($options['new_character']) {
            $textLabel = 'Histoire';
        } else {
            $textLabel = false;
        }

        $builder
            ->add('text', null, array('label' => $textLabel))
            ->add('save', SubmitType::class, array(
                 'label' => 'Envoyer',
                 'attr'  => array('class' => 'btn btn-default')
             ))
        ;

        if ($options['new_topic'] || $options['new_character']) {
            $builder->add('topic', TopicType::class);
        }

        if ($options['new_character']) {
            $builder->add('character', \ToG\RolePlayBundle\Form\Type\CharacterType::class, array('groups' => $options['groups']));
        }
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class'    => Post::class,
            'new_topic'     => false,
            'new_character' => false,
            'groups'        => false
        ));
    }
}
