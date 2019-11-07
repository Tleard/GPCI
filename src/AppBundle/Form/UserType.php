<?php

namespace AppBundle\Form;

use AppBundle\Entity\Group;
use AppBundle\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('username', TextType::class)
            ->add('email', EmailType::class)
            ->add('password', TextType::class)
            ->add('firstName', TextType::class)
            ->add('lastName', TextType::class)
            ->add('roles', ChoiceType::class, array(
                'choices' => array(
                    'Utilisateur' => 'ROLE_USER',
                    'Admin' => 'ROLE_ADMIN'
                ),
                'multiple' => true
            ))
            ->add('group', EntityType::class, array(
                'choice_label' => 'name',
                'class' => Group::class,
                'multiple' => true
            ))
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
            'data_class' => User::class
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_user_create';
    }


}
