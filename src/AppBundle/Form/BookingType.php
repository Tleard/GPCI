<?php

namespace AppBundle\Form;

use AppBundle\Entity\Courses;
use AppBundle\Entity\Room;
use AppBundle\Entity\User;
use Doctrine\DBAL\Types\DateType;
use Doctrine\DBAL\Types\TextType;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BookingType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('beginAt', DateTimeType::class, [
                'required' => true,
                'label' => 'Heure de début',
            ])
            ->add('endAt', DateTimeType::class, [
                'required' => true,
                'label' => 'Heure de fin'
            ])
/*            ->add('title', null, [
                'required' => true,
                'label' => 'booking.title'
            ])*/
            ->add('room', EntityType::class, [
                'class' => Room::class,
                'choice_label' => 'name',
                'required' => true,
                'label' => 'Salle de cours'
            ])
            ->add('course', EntityType::class, [
                'class' => Courses::class,
                'choice_label' => function ($courses) {
                    return $courses->getName() . " -" . $courses->getSupervisor()->getFirstName(). " " . $courses->getSupervisor()->getLastName() .
                        " - " . $courses->getGroups()->getName() ;
                },
                'required' => true,
                'label' => 'Matière'
            ]);
/*            ->add('supervisor', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'lastName',
                'required' => true,
                'label' => 'booking.user'
            ]);*/
    }
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Booking'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_booking';
    }


}
