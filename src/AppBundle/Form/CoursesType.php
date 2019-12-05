<?php

namespace AppBundle\Form;

use AppBundle\Entity\Courses;
use AppBundle\Entity\Group;
use AppBundle\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CoursesType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class)
            ->add('supervisor', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'lastName',
                'required' => true,
                'label' => 'Professeur'
            ])
            ->add('groups', EntityType::class, [
                'class' => Group::class,
                'choice_label' => 'name',
                'required' => true,
                'label' => 'Groupe'
            ])
            ->add('color', ChoiceType::class, [
                'required' => true,
                'choices' => array(
                    'Rouge' => 'red',
                    'Bleu' => 'blue',
                    'Violet' => 'violet',
                    'Vert' => 'green',
                    'Orange' => 'orange',
                    'Bleu Cyan' => 'cyan'

                ),
                'label' => 'Couleur'
            ])
            ->add('submit', SubmitType::class, array(
                'attr' => array(
                    'class' => 'btn btn-success'
                )
            ));
    }/**
 * {@inheritdoc}
 */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Courses::class
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_courses_create';
    }


}
