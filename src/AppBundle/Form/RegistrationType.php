<?php
// src/AppBundle/Form/RegistrationType.php

namespace AppBundle\Form;

use AppBundle\Entity\Group;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;


/**
 * Class RegistrationType
 * @package AppBundle\Form
 */
class RegistrationType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('first_name', TextType::class, array(
            'label' => 'Prénom'
        ));
        $builder->add('last_name', TextType::class, array(
        'label' => 'Nom de famille'
        ));
        $builder->add('submit', SubmitType::class, array(
            'label' => "Envoyer",
            'attr' => array(
                'class' => 'btn btn-success'
            )
        ));
        $builder->add('roles', ChoiceType::class, array(
            'label' => "Rôles",
            'choices' => array(
                'Utilisateur' => 'ROLE_USER',
                'Admin' => 'ROLE_ADMIN'
            ),
            'multiple' => true
        ));
        $builder->add('group', EntityType::class, array(
            'choice_label' => 'name',
            'class' => Group::class,
            'multiple' => true
        ));
    }

    /**
     * @return string
     */
    public function getParent()
    {
        return 'FOS\UserBundle\Form\Type\RegistrationFormType';
    }

    /**
     * @return string
     */
    public function getBlockPrefix()
    {
        return 'app_user_registration';
    }

    /**
     * @return string
     */
    public function getFirstName()
    {
        return $this->getBlockPrefix();
    }

    /**
     * @return string
     */
    public function getLastName()
    {
        return $this->getBlockPrefix();
    }
}
