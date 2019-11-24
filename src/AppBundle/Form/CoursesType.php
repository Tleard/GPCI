<?php

namespace AppBundle\Form;

use AppBundle\Entity\Courses;
use AppBundle\Entity\Group;
use AppBundle\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
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

            ->add('groups', EntityType::class, array(
                'choice_label' => 'name',
                'class' => Group::class,
                'multiple' => false
                ))
            ->add('professor', EntityType::class, array(
                'choice_label' => 'lastName',
                'class' => User::class,
                'multiple' => false
            ))
            ->add('submit', SubmitType::class, array(
                'attr' => array(
                    'class' => 'btn btn-success'
                )));
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