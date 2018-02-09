<?php

namespace ToG\ForumBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\OptionsResolver\OptionsResolver;

use ToG\ForumBundle\Entity\Forum;

class ForumType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $options['categories'] = array('Aucun' => 0) + $options['categories'];

        $builder
            ->add('name')
            ->add('description', TextareaType::class)
            ->add('type', ChoiceType::class, array(
                'choices' => [
                    'Catégorie'  => '0',
                    'Forum'      => '1',
                    'Forum-lien' => '2',
                ]
            ))
            ->add('parentId', ChoiceType::class, array('choices' => $options['categories']))
            ->add('save', SubmitType::class, array(
                 'label' => 'Enregistrer',
                 'attr'  => array('class' => 'btn btn-default')
             ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Forum::class,
            'categories' => null,
        ));
    }
}
