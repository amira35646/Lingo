<?php

namespace App\Form;

use App\Entity\Room;
use App\Enum\RoomStatus;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RoomType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('maxParticipants', IntegerType::class, [
                'label' => 'Maximum Participants',
            ])
            ->add('scheduledTime', DateType::class, [
                'widget' => 'single_text',
                'label' => 'Scheduled Date',
            ])
            ->add('durationMinutes', IntegerType::class, [
                'label' => 'Duration (minutes)',
            ])
            ->add('createdBy', TextType::class, [
                'label' => 'Created By',
            ])
            ->add('room_status', ChoiceType::class, [
                'label' => 'Status',
                'choices' => [
                    'Available' => RoomStatus::AVAILABLE,
                    'Occupied' => RoomStatus::OCCUPIED,
                    'Closed' => RoomStatus::CLOSED,
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Room::class,
        ]);
    }
}
