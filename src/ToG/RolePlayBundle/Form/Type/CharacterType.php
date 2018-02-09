<?php

namespace ToG\RolePlayBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Doctrine\Bundle\DoctrineBundle\Registry as Doctrine;
use ToG\RolePlayBundle\Entity\Character;

class CharacterType extends AbstractType
{
    /** @var \Doctrine\ORM\EntityManager */
    private $em;

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        // 1 à 5 : Novice
        // 6 à 10 : Confirmé
        // 11 à 15 : Expert
        // 16 à 20 : Prodige
        $levels = [];
        for ($i = 1; $i <= 16; $i++) {
            switch ($i)
            {
                case ($i <= 5):
                    $levels['Novice'][$i] = $i;
                    break;
                case ($i <= 10):
                    $levels['Confirmé'][$i] = $i;
                    break;
                case ($i <= 15):
                    $levels['Expert'][$i] = $i;
                    break;
                default:
                    $levels['Prodige'][$i] = $i;
            }
        }

        $builder
            ->add('name', null, array('label' => 'Nom affiché'))
            ->add('surname', null, array('label' => 'Surnom (facultatif)', 'required' => false))
            ->add('firstname', null, array('label' => 'Prénom'))
            ->add('lastname', null, array('label' => 'Nom de famille'))
            ->add('avatar', FileType::class, array(
                'label'      => 'Sélectionner votre avatar',
                'required'   => true,
                'data_class' => null,
            ))
            ->add('gender', ChoiceType::class, array(
                'label' => 'Genre',
                'choices' => [
                    'Masculin' => 'm',
                    'Féminin'  => 'f',
                    'Indéfini' => 'n',
                ],
            ))
            ->add('species', null, array('label' => 'Espèce'))
            ->add('birthdate', null, array('label' => 'Année de naissance'))
            ->add('homeworld', null, array('label' => 'Monde natal'))
            ->add('rank', null, array('label' => 'Rang'))
            ->add('level', ChoiceType::class, array(
                'label' => 'Niveau de personnage',
                'choices' => $levels,
            ))
            ->add('physical', null, array('label' => 'Description physique'))
            ->add('mental', null, array('label' => 'Description mentale'))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Character::class
        ));
    }
}
